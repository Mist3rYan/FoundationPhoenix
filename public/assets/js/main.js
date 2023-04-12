function filtrePays(){
    let valuePays = document.getElementById("pays").value;
    let longueurContact = document.getElementById("contact").options.length;
    let longueurPlanque = document.getElementById("hideout").options.length;

    for(let i = 0; i < longueurContact; i++){
        if(document.getElementById("contact").options[i].id == valuePays){
            document.getElementById("contact").options[i].style.display = "block";
        }else{
            document.getElementById("contact").options[i].style.display = "none";
        }
        document.getElementById("contact").disabled = false;
    }

    for(let j = 0; j < longueurPlanque; j++){
        if(document.getElementById("hideout").options[j].id == valuePays){
            document.getElementById("hideout").options[j].style.display = "block";
        }else{
            document.getElementById("hideout").options[j].style.display = "none";
        }
        document.getElementById("hideout").disabled = false;
    }
}

function filtreAgents(){
    let valueAgentList  = new Array();
    let longueurTarget = document.getElementById("target").options.length;
    for(let i = 0; i < longueurTarget; i++){
        if(document.getElementById("target").options[i].selected){
            valueAgentList.push(document.getElementById("target").options[i].id);
        }
    }
    let longueurAgent = document.getElementById("agent").options.length;

    for(let j = 0; j < longueurAgent; j++){
        let countryAgent= document.getElementById("agent").options[j].id ;
        if(valueAgentList.includes(countryAgent)){
            document.getElementById("agent").options[j].style.display = "none";
        }else{
            document.getElementById("agent").options[j].style.display = "block";
        }
        document.getElementById("agent").disabled = false;
    }
    document.getElementById("agent").disabled = false;
}