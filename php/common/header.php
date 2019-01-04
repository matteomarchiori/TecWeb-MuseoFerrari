<?php

function checkCounter(&$counter,&$tabIndex){
    if ($counter > 0) {
        $counter = 0;
        $tabIndex++;
    }
}

$header = file_get_contents("../../html/common/header.html");
$page = '../pages/home.php';
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$uri_parts[0] = substr($uri_parts[0], strrpos($uri_parts[0], '/')+1);

switch ($uri_parts[0]){
    case "":  
        $header = str_replace("TITLE","Homepage | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","L'homepage del museo presenta l'ultima Ferrari 250 Testa Rossa entrata in esposizione, una breve decrizione del museo e una sezione dedicata alle collezioni in esposizione prossimamente.",$header);
        $header = str_replace("KEYWORDS","Ferrari,esposizione,museo,programma",$header);
        $header = str_replace("LINKHOME","<li id='currentLink'><span xml:lang='en'>Home</span></li>",$header);
        $header = str_replace("BREADCRUMBS","<span xml:lang='en'>Home</span>",$header);
		$page = '../pages/home.php';
        break;
    case "mostre":
        $header = str_replace("TITLE","Mostre | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKMOSTRE","<li id='currentLink'>Mostre</li>",$header);
        $header = str_replace("BREADCRUMBS","Mostre",$header);
        $page = '../pages/mostre.php';
        break;
    case "mostra-corrente":
        $header = str_replace("TITLE","Mostra Corrente | Mostre | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKMOSTRACORRENTE","<li id='currentLink'>Mostra corrente</li>",$header);
        $header = str_replace("BREADCRUMBS","<a href='/mostre'>Mostre</a> > Mostra Corrente",$header);
        $page = '../pages/mostra-corrente.php';
        break;
    case "mostre-in-programma":
        $header = str_replace("TITLE","Mostre in Programma | Mostre | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKINPROGRAMMA","<li id='currentLink'>Mostre in programma</li>",$header);
        $header = str_replace("BREADCRUMBS","<a href='/mostre'>Mostre</a> > Mostre in Programma",$header);
        $page = '../pages/mostre-in-programma.php';
        break;
    case "modelli-esposti":
        $header = str_replace("TITLE","Modelli Esposti | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKMODELLI","<li id='currentLink'>Modelli esposti</li>",$header);
        $header = str_replace("BREADCRUMBS","Modelli Esposti",$header);
        $page = '../pages/modelli-esposti.php';
        break;
    case "biglietti":
        $header = str_replace("TITLE","Biglietti | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKBIGLIETTI","<li id='currentLink'>Biglietti</li>",$header);
        $header = str_replace("BREADCRUMBS","Biglietti",$header);
        $page = '../pages/biglietti.php';
        break;
    case "info-e-contatti":
        $header = str_replace("TITLE","Info e Contatti | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKINFO","<li id='currentLink'>Info e Contatti</li>",$header);
        $header = str_replace("BREADCRUMBS","Info e Contatti",$header);
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
$header = str_replace("LINKHOME","<li><a href='/' xml:lang='en' tabindex=\"$tabIndex\" accesskey=\"h\">Home</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("LINKMOSTRE","<li><a href='/mostre' tabindex=\"$tabIndex\" accesskey=\"m\">Mostre</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("LINKMOSTRACORRENTE","<li><a href='/mostre/mostra-corrente' tabindex=\"$tabIndex\" accesskey=\"c\">Mostra corrente</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("LINKINPROGRAMMA","<li><a href='/mostre/mostre-in-programma' tabindex=\"$tabIndex\" accesskey=\"p\">Mostre in programma</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("LINKMODELLI","<li><a href='/modelli-esposti?pagina=1' tabindex=\"$tabIndex\" accesskey=\"e\">Modelli esposti</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("LINKBIGLIETTI","<li><a href='/biglietti' tabindex=\"$tabIndex\" accesskey=\"b\">Biglietti</a></li>",$header,$counter);
if ($counter > 0) checkCounter($counter,$tabIndex);
$header = str_replace("LINKINFO","<li><a href='/info-e-contatti' tabindex=\"$tabIndex\" accesskey=\"i\">Info e Contatti</a></li>",$header);

echo $header;
require_once $page;
require_once '../../html/common/footer.html';