//ARRAY CON: input,pattern della regexp,output e passare a una funzione unica
//EVENTO DA USARE: onblur (opposto di onfocus), ciclo che associa a ogni input dell'array un onblur corrispondente
function checkNome(input){
	var patt = new RegExp('[a-zA-Z]{1,15}');
	if(patt.test(input)){
		return true;		
	}
	else{
		mostraErrore(input, "Il campo Nome inserito non è corretto. Rispettare il formato indicato.");
		return false;
	}
}

function checkCognome(input){
	var patt = new RegExp('[a-zA-Z]{1,15}');
	if(patt.test(input)){
		return true;		
	}
	else{
		mostraErrore(input, "Il campo Cognome inserito non è corretto. Rispettare il formato indicato.");
		return false;
	}
}

function checkTelefono(input){
	var patt = new RegExp('[0-9]{1,10}');//Sia i telefoni che i cellulari sono composti da 10 numeri
	if(patt.test(input)){
		return true;		
	}
	else{
		mostraErrore(input, "Il campo Telefono inserito non è corretto. Rispettare il formato indicato.");
		return false;
	}
}

function checkEmail(input){
	var patt = new RegExp('[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}');
	if(patt.test(input)){
		return true;		
	}
	else{
		mostraErrore(input, "Il campo Email inserito non è corretto. Rispettare il formato indicato.");
		return false;
	}
}

function checkComune(input){
	var patt = new RegExp('[a-zA-Z]{1,15}');
	if(patt.test(input)){
		return true;		
	}
	else{
		mostraErrore(input, "Il campo Comune inserito non è corretto. Rispettare il formato indicato.");
		return false;
	}
}

function checkCitta(input){
	var patt = new RegExp('[a-zA-Z]{1,15}');
	if(patt.test(input)){
		return true;		
	}
	else{
		mostraErrore(input, "Il campo Citta inserito non è corretto. Rispettare il formato indicato.");
		return false;
	}
}


function checkIndirizzo(input){
	var patt = new RegExp('(via|Via)\s[a-zA-Z]{1,30}\s[0-9]{1,4}');
	if(patt.test(input)){
		return true;
	}
	else{
		mostraErrore(input, "Il campo Indirizzo inserito non è corretto. Rispettare il formato indicato.");
		return false;
	}
}

function checkData(input){
	//TODO
	
}

function mostraErrore(input, testo){
	togliErrore(input);
	var p = input.parentNode;
	var span = document.createElement("span");
	span.className = "errori";
	span.appendChild(document.createTextNode(testo));
	p.appendChild(span);
}

function togliErrore(input){
	var p = input.parentNode;

	if(p.children.lenght > 2){
		p.removeChild(p.children[2]);
	}
}

function validazioneForm(){
	alert("ocio al pocio");
	var nome = document.getElementById("nome");
	var cognome = document.getElementById("cognome");
	var telefono = document.getElementById("telefono");
	var email = document.getElementById("email");
	var comune = document.getElementById("comune");
	var citta = document.getElementById("citta");
	var indirizzo = document.getElementById("indirizzo");
	var data = document.getElementById("data");

	var risultatoTestNome = checkNome(nome);
	var risultatoTestCognome = checkCognome(cognome);
	var risultatoTestTelefono = checkTelefono(telefono);
	var risultatoTestEmail = checkEmail(email);
	var risultatoTestComune = checkComune(comune);
	var risultatoTestCitta = checkCitta(citta);
	var risultatoTestIndirizzo = checkIndirizzo(indirizzo);
	var risultatoTestData = checkData(data);

	return risultatoTestNome && risultatoTestCognome && risultatoTestTelefono && risultatoTestEmail && risultatoTestComune && risultatoTestCitta && risultatoTestIndirizzo && risultatoTestData;
}
window.onload = function() {
  validazioneForm();
};
