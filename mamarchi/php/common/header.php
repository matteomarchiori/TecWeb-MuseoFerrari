<?php

function checkCounter(&$counter,&$tabIndex){
    if ($counter > 0) {
        $counter = 0;
        $tabIndex++;
    }
}

$header = file_get_contents("../../html/common/header.html");
$last_uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$last_uri_parts[0] = substr($last_uri_parts[0], strrpos($last_uri_parts[0], '/')+1);

switch ($last_uri_parts[0]){
    case "":  
        $header = str_replace("*title*","Homepage | Museo Ferrari",$header);
        $header = str_replace("*description*","L'homepage del museo presenta l'ultima Ferrari 250 Testa Rossa entrata in esposizione, una breve decrizione del museo e una sezione dedicata alle collezioni in esposizione prossimamente.",$header);
        $header = str_replace("*keywords*","Ferrari,esposizione,museo,programma",$header);
        $header = str_replace("*linkhome*","<li id='currentLink'><span xml:lang='en'>Home</span></li>",$header);
        $header = str_replace("*breadcrumbs*","<span xml:lang='en'>Home</span>",$header);
		$page = '../pages/home.php';
        break;
    case "mostre":
        $header = str_replace("*title*","Mostre | Museo Ferrari",$header);
        $header = str_replace("*description*","",$header);
        $header = str_replace("*keywords*","",$header);
        $header = str_replace("*linkmostre*","<li id='currentLink'>Mostre</li>",$header);
        $header = str_replace("*breadcrumbs*","Mostre",$header);
        $page = '../pages/mostre.php';
        break;
    case "mostra-corrente":
        $header = str_replace("*title*","Mostra Corrente | Mostre | Museo Ferrari",$header);
        $header = str_replace("*description*","",$header);
        $header = str_replace("*keywords*","",$header);
        $header = str_replace("*linkmostracorrente*","<li id='currentLink'>Mostra corrente</li>",$header);
        $header = str_replace("*breadcrumbs*","<a href='/mostre'>Mostre</a> > Mostra Corrente",$header);
        $page = '../pages/mostra-corrente.php';
        break;
    case "mostre-in-programma":
        $header = str_replace("*title*","Mostre in Programma | Mostre | Museo Ferrari",$header);
        $header = str_replace("*description*","",$header);
        $header = str_replace("*keywords*","",$header);
        $header = str_replace("*linkinprogramma*","<li id='currentLink'>Mostre in programma</li>",$header);
        $header = str_replace("*breadcrumbs*","<a href='/mostre'>Mostre</a> > Mostre in Programma",$header);
        $page = '../pages/mostre-in-programma.php';
        break;
    case "modelli-esposti":
        $header = str_replace("*title*","Modelli Esposti | Museo Ferrari",$header);
        $header = str_replace("*description*","",$header);
        $header = str_replace("*keywords*","",$header);
        $header = str_replace("*linkmodelli*","<li id='currentLink'>Modelli esposti</li>",$header);
        $header = str_replace("*breadcrumbs*","Modelli Esposti",$header);
        $page = '../pages/modelli-esposti.php';
        break;
    case "biglietti":
        $header = str_replace("*title*","Biglietti | Museo Ferrari",$header);
        $header = str_replace("*description*","",$header);
        $header = str_replace("*keywords*","",$header);
        $header = str_replace("*linkbiglietti*","<li id='currentLink'>Biglietti</li>",$header);
        $header = str_replace("*breadcrumbs*","Biglietti",$header);
        $page = '../pages/biglietti.php';
        break;
    case "info-e-contatti":
        $header = str_replace("*title*","Info e Contatti | Museo Ferrari",$header);
        $header = str_replace("*description*","",$header);
        $header = str_replace("*keywords*","",$header);
        $header = str_replace("*linkinfo*","<li id='currentLink'>Info e Contatti</li>",$header);
        $header = str_replace("*breadcrumbs*","Info e Contatti",$header);
        $page = '../pages/info-e-contatti.php';
        break;
    default:
        break;
}

/**
 * ACCESKEY MAP:
 * h -> home
 * m -> mostre
 * c -> mostre/correnti
 * p -> mostre/programmate
 * e -> modelli esposti
 * b -> biglietti
 * i -> info
 */
$tabIndex = 1;
$header = str_replace("*title*","Pagina non trovata",$header);
$header = str_replace("*breadcrumbs*","Pagina non trovata",$header);
$header = str_replace("*student*",$student,$header);
$header = str_replace("*linkhome*","<li><a href='./' xml:lang='en' tabindex=\"$tabIndex\" accesskey=\"h\">Home</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("*linkmostre*","<li><a href='./mostre' tabindex=\"$tabIndex\" accesskey=\"m\">Mostre</a></li>",$header,$counter);
/*if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("*linkmostracorrente*","<li><a href='/mostre/mostra-corrente' tabindex=\"$tabIndex\" accesskey=\"c\">Mostra corrente</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("*linkinprogramma*","<li><a href='/mostre/mostre-in-programma' tabindex=\"$tabIndex\" accesskey=\"p\">Mostre in programma</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);*/
$header = str_replace("*linkmodelli*","<li><a href='./modelli-esposti?pagina=1' tabindex=\"$tabIndex\" accesskey=\"e\">Modelli esposti</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("*linkbiglietti*","<li><a href='./biglietti' tabindex=\"$tabIndex\" accesskey=\"b\">Biglietti</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("*linkinfo*","<li><a href='./info-e-contatti' tabindex=\"$tabIndex\" accesskey=\"i\">Info e Contatti</a></li>",$header);
echo $header;
require_once $page;
require_once 'footer.php';