function checkCampo(input){
	
	if(!input[1].test(input[0].value)){

		mostraErrore(input[0], input[2]);
	}
}

function mostraErrore(input, testo){
	togliErrore(input);
	var p = input.parentNode;
	var span = document.createElement("span");
	span.className = "col-4 error";
	span.appendChild(document.createTextNode(testo));
	p.appendChild(span);
}

function togliErrore(input){
	var p = input.parentNode;
	if(p.children.length > 2){
		p.removeChild(p.children[2]);
	}
}

function validazione(input){
	switch (input.id) {
		case 'nome':
			var patt = new RegExp('^[a-zA-Z]{1,15}$');
			var nome = [input, patt, "Il campo Nome inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(nome);
			break;
		case 'cognome':
			var patt = new RegExp('^[a-zA-Z]{1,15}$');
			var cognome = [input, patt, "Il campo Cognome inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(cognome);
			break;
		case 'telefono':
			var patt = new RegExp('^[0-9]{1,10}$');//Sia i telefoni che i cellulari sono composti da 10 numeri
			var telefono = [input, patt, "Il campo Telefono inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(telefono);
			break;
		case 'email':
			var patt = new RegExp('^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$');
			var email = [input, patt, "Il campo Email inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(email);
			break;
		case 'comune':
			var patt = new RegExp('^[a-zA-Z]{1,15}$');
			var comune = [input, patt, "Il campo Comune inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(comune);
			break;
		case 'citta':
			var patt = new RegExp('^[a-zA-Z]{1,15}$');
			var citta = [input, patt, "Il campo Città inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(citta);
			break;
		case 'indirizzo':
			var patt = new RegExp('^(via|Via)\s[a-zA-Z]{1,30}\s[0-9]{1,4}$');
			var indirizzo = [input, patt, "Il campo Indirizzo inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(indirizzo);
			break;
		case 'data':
			//TODO
			break;
	}
}
