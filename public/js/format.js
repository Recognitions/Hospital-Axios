export function format(){
    let cpf = document.querySelector("#inputCPF")
    cpf.addEventListener("keypress",()=>{
        let length = cpf.value.length
        if(length==3 || length==7){
            cpf.value+="."
        }
        if(cpf.value.length==11){
            cpf.value+="-"
        }
    })
    let wpp = document.querySelector("#inputWPP")
    wpp.addEventListener("keypress",()=>{
        let length = wpp.value.length
        if(length==0){
            wpp.value+="("
        } else if(length==3){
            wpp.value+=")"
        } else if(length==9){
            wpp.value+="-"
        }
    })
    let eCpf = document.querySelector("#editarCPF")
    eCpf.addEventListener("keypress",()=>{
        let length = eCpf.value.length
        if(length==3 || length==7){
            eCpf.value+="."
        }
        if(eCpf.value.length==11){
            eCpf.value+="-"
        }
    })
    let eWpp = document.querySelector("#editarWPP")
    eWpp.addEventListener("keypress",()=>{
        let length = eWpp.value.length
        if(length==0){
            eWpp.value+="("
        } else if(length==3){
            eWpp.value+=")"
        } else if(length==9){
            eWpp.value+="-"
        }
    })
}