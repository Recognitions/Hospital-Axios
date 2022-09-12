export function consult(){
    const listaSintomas = [
        "Febre",
        "Coriza",
        "Nariz entupido",
        "Cansaço",
        "Tosse",
        "Dor de cabeça",
        "Dores no corpo",
        "Mal estar geral",
        "Dor de garganta",
        "Dificuldade de respirar",
        "Falta de paladar",
        "Falta de olfato",
        "Dificuldade de locomoção",
        "Diarréia"
    ]
    const resultados = [
        "<b style='color:red'>POSSÍVEL INFECTADO</b>",
        "<b style='color:orange'>POTENCIAL INFECTADO</b>",
        "<b style='color:green'>SINTOMAS INSUFICIENTES</b>",
        "<b style='color:grey'>NÃO ATENDIDO</b>"
    ]
    let somaSintomas = 0
    let sintomasPaciente = []
    let divSintomas = $("#sintomas")
    let rr
    listaSintomas.forEach(element => {
        let formCheck = $('<div/>',{
            class: 'form-check'
        }).appendTo(divSintomas);
        let formCheckInput = $('<input/>',{
            class: 'form-check-input',
            type: 'checkbox',
            value: 1
        }).appendTo(formCheck)
        let formCheckLabel = $('<label/>',{
            class: 'form-check-label',
            text: element
        }).appendTo(formCheck)

        formCheckInput.click(()=>{
            if(formCheckInput.prop("checked")){
                somaSintomas+=1
                sintomasPaciente.push(element)
            }else{
                somaSintomas-=1
                sintomasPaciente.splice(sintomasPaciente.indexOf(element),1)
            }
            if(somaSintomas>=9){
                rr = 0
            }else if(somaSintomas>=6 && somaSintomas<9){
                rr = 1
            }else if(somaSintomas<6){
                rr = 2
            }
            let resultadoFinal = resultados[rr]
            $("#resultadoSintomas").html("Resultado: "+resultadoFinal)
            $("#areaSintomas").html(sintomasPaciente+",")
            $("#sintNum").val(somaSintomas)
            $("#resultNum").val(rr)
        })
    });
}