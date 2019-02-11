function hasClass(element, className) {
    return (' ' + element.className + ' ').indexOf(' ' + className+ ' ') > -1;
}

function removeClass(element, nomeClasse) {
    element.className = element.className.replace(new RegExp('\\b' + nomeClasse + '\\b'),'');
	//ho aggiunto questo if perchè la replace lascia spazi
	if(element.className === "  "){
		element.className = "";
	}
}

function setMobile(element){
    element.className+=" mobile ";
}

function mobile(){
    var burger = document.getElementById("hamburger");
    var menu = document.getElementById("menu");

    if(burger.className === "" && window.innerWidth<830){
        setMobile(burger);
        setMobile(menu);
    }
	else if(hasClass(burger, 'mobile') && window.innerWidth>=830){
		removeClass(burger, 'mobile');
		removeClass(menu, 'mobile');
	}
}

document.getElementById("hamburger").onclick = function(){
    var menu = document.getElementById("menu");
    if(hasClass(menu,'show')){
        removeClass(menu,'show');
    }
    else{
        menu.className += 'show';
    }
};

window.onload = function() {
  mobile();
};
window.onresize = function() {
  mobile();
};