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

function ripristina(form, check) {
    var elements = form.elements;
    var i;
    for (i = 0; i < elements.length; i+=1) {
        if(elements[i].type=="text")elements[i].value = "";
    }
    var p = form.getElementsByTagName("p");
    for (i = 0; i < p.length; i+=1) {
        if (p[i].className == "col4 error") {
            p[i].parentNode.removeChild(p[i]);
            i-=1;
        }
    }
    for (i in check) {
        check[i] = true;
    }
}

window.onload = function () {
    var inputsMessage = [
        {id: "nome", regexp: new RegExp("^[a-zA-Z]{1,15}$"), output: "Il campo Nome inserito non è corretto. Rispettare il formato indicato."},
        {id: "email", regexp: new RegExp("^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$"), output: "Il campo Email inserito non è corretto. Rispettare il formato indicato."}
    ];
    
    var inputNewsletter = {id: "emailNewsletter", regexp: new RegExp("^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$"), output: "Il campo Email inserito non è corretto. Rispettare il formato indicato."};
    
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