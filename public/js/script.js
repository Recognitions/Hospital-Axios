import { format } from './format.js'
import { CPF } from './validate.js'
import { consult } from './consult.js'

const api = axios.create({
    baseURL: "http://127.0.0.1:8000"
})
var resultados = [
    "<b style='color:red'>POSSÍVEL INFECTADO</b>",
    "<b style='color:orange'>POTENCIAL INFECTADO</b>",
    "<b style='color:green'>SINTOMAS INSUFICIENTES</b>",
    "<b style='color:grey'>NÃO ATENDIDO</b>"
];
async function renderPatients(){
    const table = document.querySelector("tbody")
    const patients = await api.get('/pacientes')
    table.innerHTML=""
    patients.data.sort((a,b) => b.id - a.id);
    patients.data.forEach((patient)=>{
        const tr = document.createElement("tr")
        const ano = parseInt(patient.nasc.slice(0,4));
        const mes = parseInt(patient.nasc.slice(5,2));
        const dia = parseInt(patient.nasc.slice(8));
        const data = new Date()
        const anoAtual = data.getFullYear();
        const mesAtual = data.getMonth()+1;
        const diaAtual = data.getDate();
        const idade = anoAtual-ano;
        if(mesAtual<mes){
            idade -= 1;
        }else if((mesAtual == mes) && (diaAtual <= dia)){
            idade -= 1;
        }
        
        tr.innerHTML=`
            <th><a href="/img/pacientes/${patient.foto}"><img style="background-image:url(/img/pacientes/${patient.foto})" class="imagemPaciente"></a></th>
            <th id="nome${patient.id}" value="${patient.id}">${patient.nome}</th>
            <th id="idade${patient.id}" value="{{$paciente->nasc}}">${idade}</th>
            <th id="cpf${patient.id}">${patient.cpf}</th>
            <th id="wpp${patient.id}">${patient.wpp}</th>
            <th style="text-align:center;">${resultados[patient.estado]}</th>
            <th>
                <a href="/painel/pacientes/atender/${patient.id}"><button type="submit" class="btn btn-success w-100" name="atender">Atender</button></a>
                <a id="edit${patient.id}"><button id="E${patient.id}" type="submit" class="btn btn-warning w-100" name="atender">Editar</button></a>
                <a><button id="R${patient.id}" type="submit" class="btn btn-danger w-100" name="atender">Remover</button></a>
            </th>
        `
        table.appendChild(tr)
        document.querySelector(`#E${patient.id}`).addEventListener("click",()=>{
            const editArea = document.querySelector("#editArea")
            editArea.style.display="flex"
            document.querySelector("#editarID").value=patient.id
            document.querySelector("#editarNome").value=patient.nome
            document.querySelector("#editarIdade").value=patient.nasc
            document.querySelector("#editarCPF").value=patient.cpf
            document.querySelector("#editarWPP").value=patient.wpp
        })
        document.querySelector("#closeEditArea").addEventListener("click",()=>{
            const editArea = document.querySelector("#editArea")
            editArea.style.display="none"
        })
        document.querySelector(`#R${patient.id}`).addEventListener("click",async()=>{
            if(confirm("Deseja remover esse paciente?")==true){
                const patients = await api.get(`/painel/pacientes/remover/${patient.id}`)
                renderPatients()
            }
        })
    })
}
if(document.getElementById("inputDate")){
    renderPatients()
    format()
    const inputDate = document.getElementById("inputDate")
    inputDate.min="1900-01-01"
    const date = new Date();
    let mes
    if((date.getMonth()+1)>10){
        mes = date.getMonth()+1
    }else{
        mes = "0"+(date.getMonth()+1)
    }
    inputDate.max=(date.getFullYear()-1)+"-"+mes+"-"+date.getDate();
}

consult()

$("#salvarPaciente").submit(async(e)=>{
    e.preventDefault()
    const zap = document.getElementById("inputWPP").value
    const ddd = zap.substr(1,2)
    const prefixo = zap.substr(4,1)
    if((prefixo==9)&&(ddd>=11 && ddd<=99) && CPF(document.getElementById("inputCPF").value)==true){
        if(confirm("Completar cadastro?")==true){
            const formPatient = new FormData(document.getElementById("salvarPaciente"))
            const savePatient = await api.post('/painel/pacientes', formPatient)
            const patient = savePatient.data
            renderPatients()
            document.getElementById("nome").value = document.getElementById("inputCPF").value = document.getElementById("inputWPP").value = document.getElementById("inputDate").value = document.getElementById("formFile").value = ""
            setTimeout(()=>{
                document.querySelector("tbody tr:first-child").classList.add("firstTr")
                setTimeout(()=>{
                document.querySelector("tbody tr:first-child").classList.remove("firstTr")
                },300)
            },100)
        }
    }else{
        alert("PREENCHA OS CAMPOS CORRETAMENTE!")
    }
})
$("#editArea form").submit(async(e)=>{
    e.preventDefault()
    const zap = document.getElementById("editarWPP").value
    const ddd = zap.substr(1,2)
    const prefixo = zap.substr(4,1)
    if((prefixo==9)&&(ddd>=11 && ddd<=99) && CPF(document.getElementById("editarCPF").value)==true){
        if(confirm("Confirmar edições?")==true){
            const formEdit = new FormData(document.querySelector("#editArea form"))
            const editPatient = await api.post("/painel/pacientes/editar",formEdit)
            renderPatients()
            alert("Editado com sucesso!")
        }
    }else{
        alert("PREENCHA OS CAMPOS CORRETAMENTE!")
    }
})
$("#atenderPaciente").submit(async(e)=>{
    e.preventDefault()
    if(confirm("Realizar atendimento?")==true){
        const url = (window.location.href).split("/")
        const formAtten = new FormData(document.getElementById("atenderPaciente"))
        const atten = await api.post(`/painel/pacientes/atender/${url[6]}`,formAtten)
        const br = $("#boxResultado")
        br.html('')
        const successa = $("<div/>",{
            class: "alert alert-success alert-dismissible fade show",
            role: "alert",
            id: "meuAlertae",
            text: "Paciente Atendido!",
            style:"margin-top:10px"
        }).appendTo(br)
        $("<button/>",{
            class:"btn-close",
            data:"alert",
            id:"btndoalerta"
        }).appendTo(successa)
        $("#meuAlertae button").click(()=>{successa.hide()})
        attend()
    }
})

async function attend(){
    const url = (window.location.href).split("/")
    let card = document.querySelector(".card")
    const atendimento = await api.get(`/painel/pacientes/atenda/${url[6]}`)
    const ano = (atendimento.data.updated_at).substr(0,4)
    const mes = (atendimento.data.updated_at).substr(5,2)
    const dia = (atendimento.data.updated_at).substr(8,2)
    const date = dia+"/"+mes+"/"+ano
    const hora = (atendimento.data.updated_at).substr(11,2)-3
    const horario = hora+""+(atendimento.data.updated_at).substr(13,3)
    card.innerHTML=`
        <img src="/img/pacientes/${atendimento.data.foto}" class="card-img-top">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">${atendimento.data.nome}</li>
            <li class="list-group-item"><b>${resultados[atendimento.data.estado]}</b></li>
            <li class="list-group-item"><b>Atualizado em: ${date}</b></li>
            <li class="list-group-item"><b>Horário: ${horario}</b></li>
        </ul>
    `
}
if(((window.location.href).split("/")).length>6){attend()}