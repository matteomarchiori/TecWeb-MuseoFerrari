window.onload = function () {
    common();
    
    var inputsMessage = [
        {id: "nome", regexp: new RegExp("^[a-zA-Z]{1,15}$"), output: "Il campo Nome inserito non è corretto. Rispettare il formato indicato."},
        {id: "email", regexp: new RegExp("^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$"), output: "Il campo <span xml:lang=\"en\">Email</span> inserito non è corretto. Rispettare il formato indicato."}
    ];
    
    var inputNewsletter = {id: "emailNewsletter", regexp: new RegExp("^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$"), output: "Il campo <span xml:lang=\"en\">Email</span> inserito non è corretto. Rispettare il formato indicato."};
    
    var checkMessaggio = {};
    var checkNewsletter = {};
    
    var i;
    for (i = 0; i < inputsMessage.length; i+=1){
        validazioneOnBlur(inputsMessage[i], checkMessaggio);
    }
    validazioneOnBlur(inputNewsletter, checkNewsletter);
    
    var formContattaci = document.getElementById("formContattaci");
    formContattaci.onsubmit = function () {
        for (i = 0; i < inputsMessage.length; i+=1){
            validazione(inputsMessage[i], checkMessaggio);
        }
        var send = true;
        for (i in checkMessaggio) {
            if (!checkMessaggio[i]) {
                send = false;
            }
        }
        return send;
    };
    
    var resetMessaggio = document.getElementById("resetMessaggio");
    resetMessaggio.onclick = function () {
        ripristina(formContattaci, checkMessaggio);
        return false;
    };
    
    var formNews = document.getElementById("formNews");
    formNews.onsubmit = function () {
        validazione(inputNewsletter, checkNewsletter);
        var send = true;
        if (!checkNewsletter["emailNewsletter"]) {
            send = false;
        }
        return send;
    };
    
    var resetNewsletter = document.getElementById("resetNewsletter");
    resetNewsletter.onclick = function () {
        ripristina(formNews, checkNewsletter);
        return false;
    };
};
