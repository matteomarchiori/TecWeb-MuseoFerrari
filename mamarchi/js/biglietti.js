window.onload = function () {
    common();
    
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
        {id: "email", regexp: new RegExp("^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$"), output: "Il campo <span xml:lang=\"en\">Email</span> inserito non è corretto. Rispettare il formato indicato."},
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
        if(check["giornomostra"]){
            validazioneDataMostra(giornomostra, mesemostra, annomostra, check);
        }
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
