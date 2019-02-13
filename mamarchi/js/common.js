function setMobile(element){
    element.className+=" mobile ";
}

function hasClass(element, className) {
    return (" " + element.className + " ").indexOf(" " + className + " ") > -1;
}

function removeClass(element, nomeClasse) {
    element.className = element.className.replace(new RegExp("\\b" + nomeClasse + "\\b"),"");
    if(element.className == "  "){
        element.className = "";
    }
}

function mobile() {
    var burger = document.getElementById("hamburger");
    var menu = document.getElementById("menu");

    if (burger.className == "" && window.innerWidth < 830) {
        setMobile(burger);
        setMobile(menu);
    } else if (hasClass(burger, "mobile") && window.innerWidth >= 830) {
        removeClass(burger, "mobile");
        removeClass(menu, "mobile");
    }
}

function common(){
    mobile();
    document.getElementById("hamburger").onclick = function () {
        var menu = document.getElementById("menu");
        if (hasClass(menu, "show")) {
            removeClass(menu, "show");
        } else {
            menu.className += "show";
        }
    };
}

function checkData(giorno, mese, anno) {
    var data = anno + "-" + mese + "-" + giorno;
    var regexp = new RegExp("^[1|2][0-9]{3,3}-([1-9]|1[0|1|2])-([1-9]|[1|2][0-9]|3[0|1])$");
    if (regexp.test(data)) {
        if (giorno == 31 && (mese == 4 || mese == 6 || mese == 9 || mese == 11)){
            return false;
        }
        if (giorno > 29 && mese == 2){
            return false;
        }
        if (giorno == 29 && mese == 2 && !(anno % 4 == 0 && (anno % 100 != 0 || anno % 400 == 0))){
            return false;
        }
        return true;
    }
    return false;
}

function checkBoundLimit(element, min, max) {
    return min <= element && element <= max;
}

function togliErrore(container) {
    var figli = container.childNodes;
    if (hasClass(figli[figli.length - 1], "error")) {
        container.removeChild(figli[figli.length - 1]);
    }
}

function mostraErrore(container, testo) {
    togliErrore(container);
    var paragraph = document.createElement("p");
    paragraph.className = "col4 error";
    paragraph.innerHTML = testo;
    container.appendChild(paragraph);
}

function validazione(input, check) {
    var i = document.getElementById(input.id);
    check[input.id] = input.regexp.test(i.value);
    if (check[input.id]) {
        togliErrore(i.parentNode.parentNode);
    } else {
        mostraErrore(i.parentNode.parentNode, input.output);
    }
}

function validazioneOnBlur(input, check) {
    var i = document.getElementById(input.id);
    i.onblur = function () {
        validazione(input, check);
    };
}

function validazioneData(giorno, mese, anno, errore, check) {
    var container = giorno.parentNode.parentNode.parentNode;
    var g = giorno.options[giorno.selectedIndex].value;
    var m = mese.options[mese.selectedIndex].value;
    var a = anno.options[anno.selectedIndex].value;
    check[giorno.id] = checkData(g, m, a);
    if(check[giorno.id]){
        togliErrore(container);
    } else {
        mostraErrore(container, errore);
    }
}

function validazioneDataOnChange(giorno, mese, anno, errore, check) {
    giorno.onchange = function () {
        validazioneData(giorno, mese, anno, errore, check);
    };
    mese.onchange = function () {
        validazioneData(giorno, mese, anno, errore, check);
    };
    anno.onchange = function () {
        validazioneData(giorno, mese, anno, errore, check);
    };
}

function getMonthName(n) {
    switch (n) {
        case 0:
            return "Gennaio";
        case 1:
            return "Febbraio";
        case 2:
            return "Marzo";
        case 3:
            return "Aprile";
        case 4:
            return "Maggio";
        case 5:
            return "Giugno";
        case 6:
            return "Luglio";
        case 7:
            return "Agosto";
        case 8:
            return "Settembre";
        case 9:
            return "Ottobre";
        case 10:
            return "Novembre";
        case 11:
            return "Dicembre";
    }
}


function ripristina(form, check) {
    var elements = form.elements;
    var i;
    for (i = 0; i < elements.length; i+=1) {
        switch (elements[i].type) {
            case "text":
                elements[i].value = "";
                break;
            case "checkbox":
                elements[i].checked = false;
                break;
        }
    }
    var p = form.getElementsByTagName("p");
    for (i = 0; i < p.length; i+=1) {
        if (hasClass(p[i], "error")) {
            p[i].parentNode.removeChild(p[i]);
            i-=1;
        }
    }
    for (i in check) {
        check[i] = true;
    }
}

function validazioneDataMostra(giorno, mese, anno, check){
    var container = giorno.parentNode.parentNode.parentNode;
    var g = giorno.options[giorno.selectedIndex].value;
    var m = mese.options[mese.selectedIndex].value;
    var a = anno.options[anno.selectedIndex].value;
    var data = new Date(a+"-"+m+"-"+g);
    var now = new Date();
    var today = new Date(now.getFullYear()+"-"+(now.getMonth()+1)+"-"+now.getDate());
    var mostra = document.getElementById("mostra");
    var idmostra = mostra.options[mostra.selectedIndex].value;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var response = JSON.parse(request.responseText);
            var dataInizio = new Date(response["DataInizio"]);
            var dataFine = new Date(response["DataFine"]);
            var inizio = dataInizio.getTime();
            var adesso = today.getTime();
            if(adesso>inizio){
                inizio = adesso;
                dataInizio = new Date();
            }
            check[giorno.id] = checkBoundLimit(data.getTime(), inizio, dataFine.getTime());
            if(check[giorno.id]){
                togliErrore(container);
            }
            else{
                var errore = "Non è possibile prenotare per il giorno selezionato. Selezionare una data compresa tra il "+dataInizio.getDate()+" "+getMonthName(dataInizio.getMonth())+" "+dataInizio.getFullYear()+" e il "+dataFine.getDate()+" "+getMonthName(dataFine.getMonth())+" "+dataFine.getFullYear()+".";
                mostraErrore(container,errore);
            }
        }
    };
    request.open("get","./php/request/mostra.php?id="+idmostra,false);
    request.setRequestHeader("Content-Type", "application/json");
    request.send();
}

function pulsanti(){
    if(window.innerWidth >= 830){
        var back = document.getElementById("pulsanteBack");
        var numpagina = document.getElementById("numPagina");
        var next = document.getElementById("pulsanteNext");
        if(back===null && next===null){
            numpagina.className += " vuotoSinistro vuotoDestro ";
        }
        else if(back===null){
            numpagina.className += " vuotoSinistro ";
        }
    }
}

window.onresize = function () {
    mobile();
};