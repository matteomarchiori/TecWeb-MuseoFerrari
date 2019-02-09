var now = new Date();
var MINANNONASCITA = now.getFullYear()-100;
var MAXANNONASCITA = now.getFullYear()-18;
var MINBIGLIETTI = 1;
var MAXBIGLIETTI = 8;

var stati = [
    {id: 'it', nome:'Italia'},
    {id: 'fr', nome:'France'},
    {id: 'uk', nome:'United Kingdom'}
];

var regExpStati = '^';
var nstati = stati.length;
for(var i=0;i<nstati;i++){
    regExpStati+='['+stati[i]['id']+']';
    if(i!==nstati-1) regExpStati+='|';
}
regExpStati+='$';

var inputs = [
    {id: 'nome', regexp: new RegExp('^[a-zA-Z]{1,15}$'), output: 'Il campo Nome inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'cognome', regexp: new RegExp('^[a-zA-Z]{1,15}$'), output: 'Il campo Cognome inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'telefono', regexp: new RegExp('^[0-9]{1,10}$'), output: 'Il campo Telefono inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'email', regexp: new RegExp('^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$'), output: 'Il campo Email inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'comune', regexp: new RegExp('^[a-zA-Z]{1,15}$'), output: 'Il campo Comune inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'citta', regexp: new RegExp('^[a-zA-Z]{1,15}$'), output: 'Il campo Città inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'indirizzo', regexp: new RegExp('^[a-zA-Z]{1,10}\s[a-zA-Z]{1,30}\s[0-9]{1,4}$'), output: 'Il campo Indirizzo inserito non è corretto. Rispettare il formato indicato.'},
    {id: 'stato', regexp: new RegExp(regExpStati), output: 'Il campo Stato selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati.'},
    {id: 'nbiglietti', regexp: new RegExp('^[' + MINBIGLIETTI + '-' + MAXBIGLIETTI + ']$'),  output: 'Il numero di biglietti selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati.'}
];

var dateFields = [
    {id: 'giornonascita', label: 'Giorno di nascita'},
    {id: 'mesenascita', label: 'Mese di nascita'},
    {id: 'annonascita', label: 'Anno di nascita'},
    {id: 'giornomostra', label: 'Giorno della mostra'},
    {id: 'mesemostra', label: 'Mese della mostra'},
    {id: 'annomostra', label: 'Anno della mostra'}
];


function mostraErrore(input, testo) {
    togliErrore(input);
    var p = input.parentNode.parentNode;
    var paragraph = document.createElement("p");
    paragraph.className = "col4 error";
    paragraph.appendChild(document.createTextNode(testo));
    p.appendChild(paragraph);
}

function togliErrore(input) {
    var p = input.parentNode.parentNode;
    if (p.children.length > 2) {
        p.removeChild(p.children[2]);
    }
}

function validazione(input) {
    var i = document.getElementById(input.id);
    i.onblur = function () {
        var result = input.regexp.test(i.value);
        if (result)
            togliErrore(i);
        else
            mostraErrore(i, input.output);
    };
}

window.onload = function () {
    for (var i = 0; i < inputs.length; i++)
        validazione(inputs[i]);
};