var now = new Date();
var MINANNONASCITA = now.getFullYear() - 100;
var MAXANNONASCITA = now.getFullYear() - 18;
var MINBIGLIETTI = 1;
var MAXBIGLIETTI = 8;

var stati = [
    {id: 'it', nome: 'Italia'},
    {id: 'fr', nome: 'France'},
    {id: 'uk', nome: 'United Kingdom'}
];

var regExpStati = '^';
var nstati = stati.length;
for (var i = 0; i < nstati; i++) {
    regExpStati += '[' + stati[i]['id'] + ']';
    if (i !== nstati - 1)
        regExpStati += '|';
}
regExpStati += '$';

var inputs = [
    {id: 'nome', regexp: new RegExp('^[a-zA-Z]{1,15}$'), output: 'Il campo Nome inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'cognome', regexp: new RegExp('^[a-zA-Z]{1,15}$'), output: 'Il campo Cognome inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'telefono', regexp: new RegExp('^[0-9]{1,10}$'), output: 'Il campo Telefono inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'email', regexp: new RegExp('^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$'), output: 'Il campo Email inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'comune', regexp: new RegExp('^[a-zA-Z]{1,15}$'), output: 'Il campo Comune inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'citta', regexp: new RegExp('^[a-zA-Z]{1,15}$'), output: 'Il campo Città inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'indirizzo', regexp: new RegExp('^[a-zA-Z]{1,10}\s[a-zA-Z]{1,30}\s[0-9]{1,4}$'), output: 'Il campo Indirizzo inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'stato', regexp: new RegExp(regExpStati), output: 'Il campo Stato selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati.'},
    {id: 'nbiglietti', regexp: new RegExp('^[' + MINBIGLIETTI + '-' + MAXBIGLIETTI + ']$'), output: 'Il numero di biglietti selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati.'}
];

var dateFields = [
    {id: 'giornonascita', label: 'Giorno di nascita'},
    {id: 'mesenascita', label: 'Mese di nascita'},
    {id: 'annonascita', label: 'Anno di nascita'},
    {id: 'giornomostra', label: 'Giorno della mostra'},
    {id: 'mesemostra', label: 'Mese della mostra'},
    {id: 'annomostra', label: 'Anno della mostra'}
];


function checkData(giorno, mese, anno) {
    data = anno + '-' + mese + '-' + giorno;
    var regexp = new RegExp('^[1|2][0-9]{3,3}-([1-9]|1[0|1|2])-([1-9]|[1|2][0-9]|3[0|1])$');
    if (regexp.test(data)) {
        if (giorno === 31 && (mese === 4 || mese === 6 || mese === 9 || mese === 11))
            return false;
        if (giorno > 29 && mese === 2)
            return false;
        if (giorno === 29 && mese === 2 && !(anno % 4 === 0 && (anno % 100 !== 0 || anno % 400 === 0)))
            return false;
        return true;
    }
    return false;
}

function checkBoundLimit(element, min, max) {
    return min <= element && element <= max;
}


function mostraErrore(container, testo) {
    togliErrore(container);
    var paragraph = document.createElement("p");
    paragraph.className = "col4 error";
    paragraph.appendChild(document.createTextNode(testo));
    container.appendChild(paragraph);
}

function togliErrore(container) {
    var figli = container.childNodes;
    if(figli[figli.length-1].className==="col4 error"){
        container.removeChild(figli[figli.length-1]);
    }
}

function validazione(input) {
    var i = document.getElementById(input.id);
    i.onblur = function () {
        var result = input.regexp.test(i.value);
        if (result)
            togliErrore(i.parentNode.parentNode);
        else
            mostraErrore(i.parentNode.parentNode, input.output);
    };
}

function ripristina(form){
    var elements = form.elements;
    for (var i = 0; i < elements.length; i++) {
        switch (elements[i].type) {
            case "text":
                elements[i].value = "";
                break;
            case "checkbox":
                elements[i].checked = false;
                break;
        }
    }
}

window.onload = function () {
    for (var i = 0; i < inputs.length; i++)
        validazione(inputs[i]);
    
    var giornonascita = document.getElementById("giornonascita");
    var mesenascita = document.getElementById("mesenascita");
    var annonascita = document.getElementById("annonascita");
    
    giornonascita.onchange = function(){
        var gn = giornonascita.options[giornonascita.selectedIndex].value;
        var mn = mesenascita.options[mesenascita.selectedIndex].value;
        var an = annonascita.options[annonascita.selectedIndex].value;
        if(checkData(gn,mn,an)) togliErrore(giornonascita.parentNode.parentNode.parentNode);
        else mostraErrore(giornonascita.parentNode.parentNode.parentNode,"Ciaoooo");
    };
    
    var reset = document.getElementById("reset");
    reset.addEventListener("click",function(event){
        ripristina(document.getElementById("formBiglietti"));
        event.returnValue = false;
    });
};