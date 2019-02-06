function checkCampo(input){
	if(input[1].test(input[0].value)){
		togliErrore(input[0]);
	}
	else{
		mostraErrore(input[0], input[2]);
	}
}

function mostraErrore(input, testo){
    togliErrore(input);
	var p = input.parentNode;
	var paragraph = document.createElement("p");
	paragraph.className = "error";
    paragraph.setAttribute("id","javascript");
	paragraph.appendChild(document.createTextNode(testo));
	p.appendChild(paragraph);
}

function togliErrore(input){
	var p = input.parentNode;
	//alert(p.children.length);
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
		case 'email':
			var patt = new RegExp('^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$');
			var email = [input, patt, "Il campo Email inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(email);
			break;
		case 'emailNewsletter':
			var patt = new RegExp('^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$');
			var email = [input, patt, "Il campo Email inserito non è corretto. Rispettare il formato indicato."];
			checkCampo(email);
			break;
	}
}
