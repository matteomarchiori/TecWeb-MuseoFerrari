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
    if (figli[figli.length - 1].className === "col4 error") {
        container.removeChild(figli[figli.length - 1]);
    }
}

function mostraErrore(container, testo) {
    togliErrore(container);
    var paragraph = document.createElement("p");
    paragraph.className = "col4 error";
    paragraph.appendChild(document.createTextNode(testo));
    container.appendChild(paragraph);
}

function validazione(input, check) {
    var i = document.getElementById(input.id);
    var result = input.regexp.test(i.value);
    if (result) {
        check[input.id] = true;
        togliErrore(i.parentNode.parentNode);
    } else {
        check[input.id] = false;
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
    if (checkData(g, m, a)) {
        check[giorno.id] = true;
        togliErrore(container);
    } else {
        check[giorno.id] = false;
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
    var p = document.getElementsByTagName("p");
    for (i = 0; i < p.length; i+=1) {
        if (p[i].className == "col4 error") {
            p[i].parentNode.removeChild(p[i]);
        }
    }
    for (i in check) {
        check[i] = true;
    }
}

window.onload = function () {
    var now = new Date();
    var MINBIGLIETTI = 1;
    var MAXBIGLIETTI = 8;

    var stati = [
        {id: "it", nome: "Italia"},
        {id: "fr", nome: "France"},
        {id: "uk", nome: "United Kingdom"}
    ];

    var regExpStati = "^";
    var nstati = stati.length;
    var i;
    for (i = 0; i < nstati; i+=1) {
        regExpStati += "[" + stati[i].id + "]";
        if (i != nstati - 1){
            regExpStati += "|";
        }
    }
    regExpStati += "$";

    var inputs = [
        {id: "nome", regexp: new RegExp("^[a-zA-Z]{1,15}$"), output: "Il campo Nome inserito non è corretto. Rispettare il formato indicato."},
        {id: "cognome", regexp: new RegExp("^[a-zA-Z]{1,15}$"), output: "Il campo Cognome inserito non è corretto. Rispettare il formato indicato."},
        {id: "telefono", regexp: new RegExp("^[0-9]{1,10}$"), output: "Il campo Telefono inserito non è corretto. Rispettare il formato indicato."},
        {id: "email", regexp: new RegExp("^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$"), output: "Il campo Email inserito non è corretto. Rispettare il formato indicato."},
        {id: "comune", regexp: new RegExp("^[a-zA-Z]{1,15}$"), output: "Il campo Comune inserito non è corretto. Rispettare il formato indicato."},
        {id: "citta", regexp: new RegExp("^[a-zA-Z]{1,15}$"), output: "Il campo Città inserito non è corretto. Rispettare il formato indicato."},
        {id: "indirizzo", regexp: new RegExp("^[a-zA-Z]{1,10}\\s[a-zA-Z\\s]{1,30}\\s[0-9]{1,4}$"), output: "Il campo Indirizzo inserito non è corretto. Rispettare il formato indicato."},
        {id: "stato", regexp: new RegExp(regExpStati), output: "Il campo Stato selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati."},
        {id: "nbiglietti", regexp: new RegExp("^[" + MINBIGLIETTI + "-" + MAXBIGLIETTI + "]$"), output: "Il numero di biglietti selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati."}
    ];

    var check = {};

    for (i = 0; i < inputs.length; i+=1){
        validazioneOnBlur(inputs[i], check);
    }

    var giornonascita = document.getElementById("giornonascita");
    var mesenascita = document.getElementById("mesenascita");
    var annonascita = document.getElementById("annonascita");
    var errorenascita = "La data di nascita non è coerente. Non esiste il giorno indicato nel mese indicato. Si prega di correggere la data.";
    validazioneDataOnChange(giornonascita, mesenascita, annonascita, errorenascita, check);

    var giornomostra = document.getElementById("giornomostra");
    var mesemostra = document.getElementById("mesemostra");
    var annomostra = document.getElementById("annomostra");
    var erroremostra = "La data della mostra non è coerente. Non esiste il giorno indicato nel mese indicato. Si prega di correggere la data.";
    validazioneDataOnChange(giornomostra, mesemostra, annomostra, erroremostra, check);

    var form = document.getElementById("formBiglietti");
    form.onsubmit = function () {
        for (i = 0; i < inputs.length; i+=1){
            validazione(inputs[i], check);
        }
        validazioneData(giornonascita, mesenascita, annonascita, errorenascita, check);
        validazioneData(giornomostra, mesemostra, annomostra, erroremostra, check);
        var send = true;
        for (i in check) {
            if (!check[i]) {
                send = false;
            }
        }
        return send;
    };

    var reset = document.getElementById("reset");
    reset.onclick = function () {
        ripristina(form, check);
        return false;
    };
};