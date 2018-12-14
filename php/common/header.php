<?php
$header = file_get_contents("../../html/common/header.html");
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

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

switch ($uri_parts[0]){
    case "/":   // TABINDEX ACCESSKEY OK
        $header = str_replace("TITLE","Homepage | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","L'homepage del museo presenta l'ultima Ferrari 250 Testa Rossa entrata in esposizione, una breve decrizione del museo e una sezione dedicata alle collezioni in esposizione prossimamente.",$header);
        $header = str_replace("KEYWORDS","Ferrari,esposizione,museo,programma",$header);
        $header = str_replace("LINKHOME","<li id='currentLink'><span xml:lang='en'>Home</span></li>",$header);
        $header = str_replace("LINKMOSTRE","<li><a href='/mostre' tabindex=\"1\" accesskey=\"m\">Mostre</a></li>",$header);
        $header = str_replace("LINKMOSTRACORRENTE","<li><a href='/mostre/mostra-corrente' tabindex=\"2\" accesskey=\"c\">Mostra corrente</a></li>",$header);
        $header = str_replace("LINKINPROGRAMMA","<li><a href='/mostre/mostre-in-programma' tabindex=\"3\" accesskey=\"p\">Mostre in programma</a></li>",$header);
        $header = str_replace("LINKMODELLI","<li><a href='/modelli-esposti?pagina=1' tabindex=\"4\" accesskey=\"e\">Modelli esposti</a></li>",$header);
        $header = str_replace("LINKBIGLIETTI","<li><a href='/biglietti' tabindex=\"5\" accesskey=\"s\">Biglietti</a></li>",$header);
        $header = str_replace("LINKINFO","<li><a href='/info-e-contatti' tabindex=\"6\" accesskey=\"i\">Info e Contatti</a></li>",$header);
        $header = str_replace("BREADCRUMBS","<span xml:lang='en'>Home</span>",$header);
        echo $header;
        //include '../../html/pages/home.html';
		include '../pages/home.php';
        break;
    case "/mostre": // TABINDEX ACCESSKEY OK
        $header = str_replace("TITLE","Mostre | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKHOME","<li><a href='/' xml:lang='en' tabindex=\"1\" accesskey=\"h\">Home</a></li>",$header);
        $header = str_replace("LINKMOSTRE","<li id='currentLink'>Mostre</li>",$header);
        $header = str_replace("LINKMOSTRACORRENTE","<li><a href='/mostre/mostra-corrente'tabindex=\"2\" accesskey=\"c\">Mostra corrente</a></li>",$header);
        $header = str_replace("LINKINPROGRAMMA","<li><a href='/mostre/mostre-in-programma' tabindex=\"3\" accesskey=\"p\">Mostre in programma</a></li>",$header);
        $header = str_replace("LINKMODELLI","<li><a href='/modelli-esposti?pagina=1' tabindex=\"4\" accesskey=\"e\">Modelli esposti</a></li>",$header);
        $header = str_replace("LINKBIGLIETTI","<li><a href='/biglietti' tabindex=\"5\" accesskey=\"b\" >Biglietti</a></li>",$header);
        $header = str_replace("LINKINFO","<li><a href='/info-e-contatti' tabindex=\"6\" accesskey=\"i\">Info e Contatti</a></li>",$header);
        $header = str_replace("BREADCRUMBS","Mostre",$header);
        echo $header;
        include '../pages/mostre.php';
        break;
    case "/mostre/mostra-corrente": // TABINDEX ACCESSKEY OK
        $header = str_replace("TITLE","Mostra Corrente | Mostre | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKHOME","<li><a href='/' xml:lang='en' tabindex=\"1\" accesskey=\"h\">Home</a></li>",$header);
        $header = str_replace("LINKMOSTRE","<li id='currentLink'><a href='/mostre' tabindex=\"2\" accesskey=\"m\">Mostre</a></li>",$header);
        $header = str_replace("LINKMOSTRACORRENTE","<li>Mostra corrente</li>",$header);
        $header = str_replace("LINKINPROGRAMMA","<li><a href='/mostre/mostre-in-programma' tabindex=\"3\" accesskey=\"p\">Mostre in programma</a></li>",$header);
        $header = str_replace("LINKMODELLI","<li><a href='/modelli-esposti?pagina=1' tabindex=\"4\" accesskey=\"e\">Modelli esposti</a></li>",$header);
        $header = str_replace("LINKBIGLIETTI","<li><a href='/biglietti' tabindex=\"5\" accesskey=\"b\">Biglietti</a></li>",$header);
        $header = str_replace("LINKINFO","<li><a href='/info-e-contatti' tabindex=\"6\" accesskey=\"i\">Info e Contatti</a></li>",$header);
        $header = str_replace("BREADCRUMBS","<a href='/mostre'>Mostre</a> > Mostra Corrente",$header);
        echo $header;
        include '../pages/mostra-corrente.php';
        break;
    case "/mostre/mostre-in-programma": // TABINDEX ACCESSKEY OK
        $header = str_replace("TITLE","Mostre in Programma | Mostre | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKHOME","<li><a href='/' xml:lang='en' tabindex=\"1\" accesskey=\"h\">Home</a></li>",$header);
        $header = str_replace("LINKMOSTRE","<li id='currentLink'><a href='/mostre' tabindex=\"2\" accesskey=\"m\">Mostre</a></li>",$header);
        $header = str_replace("LINKMOSTRACORRENTE","<li><a href='/mostre/mostra-corrente' tabindex=\"3\" accesskey=\"c\">Mostra corrente</a></li>",$header);
        $header = str_replace("LINKINPROGRAMMA","<li>Mostre in programma</li>",$header);
        $header = str_replace("LINKMODELLI","<li><a href='/modelli-esposti?pagina=1' tabindex=\"4\" accesskey=\"e\">Modelli esposti</a></li>",$header);
        $header = str_replace("LINKBIGLIETTI","<li><a href='/biglietti' tabindex=\"5\" accesskey=\"b\">Biglietti</a></li>",$header);
        $header = str_replace("LINKINFO","<li><a href='/info-e-contatti' tabindex=\"6\" accesskey=\"i\">Info e Contatti</a></li>",$header);
        $header = str_replace("BREADCRUMBS","<a href='/mostre'>Mostre</a> > Mostre in Programma",$header);
        echo $header;
        include '../pages/mostre-in-programma.php';
        break;
    case "/modelli-esposti": // TABINDEX ACCESSKEY OK
        $header = str_replace("TITLE","Modelli Esposti | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKHOME","<li><a href='/' xml:lang='en' tabindex=\"1\" accesskey=\"h\">Home</a></li>",$header);
        $header = str_replace("LINKMOSTRE","<li><a href='/mostre' tabindex=\"2\" accesskey=\"m\">Mostre</a></li>",$header);
        $header = str_replace("LINKMOSTRACORRENTE","<li><a href='/mostre/mostra-corrente' tabindex=\"3\" accesskey=\"c\">Mostra corrente</a></li>",$header);
        $header = str_replace("LINKINPROGRAMMA","<li><a href='/mostre/mostre-in-programma' tabindex=\"4\" accesskey=\"p\">Mostre in programma</a></li>",$header);
        $header = str_replace("LINKMODELLI","<li id='currentLink'>Modelli esposti</li>",$header);
        $header = str_replace("LINKBIGLIETTI","<li><a href='/biglietti' tabindex=\"5\" accesskey=\"b\">Biglietti</a></li>",$header);
        $header = str_replace("LINKINFO","<li><a href='/info-e-contatti' tabindex=\"6\" accesskey=\"i\">Info e Contatti</a></li>",$header);
        $header = str_replace("BREADCRUMBS","Modelli Esposti",$header);
        echo $header;
        include '../pages/modelli-esposti.php';
        break;
    case "/biglietti": // TABINDEX ACCESSKEY OK
        $header = str_replace("TITLE","Biglietti | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKHOME","<li><a href='/' xml:lang='en' tabindex=\"1\" accesskey=\"h\">Home</a></li>",$header);
        $header = str_replace("LINKMOSTRE","<li><a href='/mostre' tabindex=\"2\" accesskey=\"m\">Mostre</a></li>",$header);
        $header = str_replace("LINKMOSTRACORRENTE","<li><a href='/mostre/mostra-corrente' tabindex=\"3\" accesskey=\"c\">Mostra corrente</a></li>",$header);
        $header = str_replace("LINKINPROGRAMMA","<li><a href='/mostre/mostre-in-programma tabindex=\"4\" accesskey=\"p\"'>Mostre in programma</a></li>",$header);
        $header = str_replace("LINKMODELLI","<li><a href='/modelli-esposti?pagina=1' tabindex=\"5\" accesskey=\"e\">Modelli esposti</a></li>",$header);
        $header = str_replace("LINKBIGLIETTI","<li id='currentLink'>Biglietti</li>",$header);
        $header = str_replace("LINKINFO","<li><a href='/info-e-contatti' tabindex=\"6\" accesskey=\"i\">Info e Contatti</a></li>",$header);
        $header = str_replace("BREADCRUMBS","Biglietti",$header);
        echo $header;
        include '../../html/pages/biglietti.html';
        break;
    case "/info-e-contatti": // TABINDEX ACCESSKEY OK
        $header = str_replace("TITLE","Info e Contatti | Museo Ferrari",$header);
        $header = str_replace("DESCRIPTION","",$header);
        $header = str_replace("KEYWORDS","",$header);
        $header = str_replace("LINKHOME","<li><a href='/' xml:lang='en' tabindex=\"1\" accesskey=\"h\">Home</a></li>",$header);
        $header = str_replace("LINKMOSTRE","<li><a href='/mostre' tabindex=\"2\" accesskey=\"m\">Mostre</a></li>",$header);
        $header = str_replace("LINKMOSTRACORRENTE","<li><a href='/mostre/mostra-corrente' tabindex=\"3\" accesskey=\"c\">Mostra corrente</a></li>",$header);
        $header = str_replace("LINKINPROGRAMMA","<li><a href='/mostre/mostre-in-programma' tabindex=\"4\" accesskey=\"p\">Mostre in programma</a></li>",$header);
        $header = str_replace("LINKMODELLI","<li><a href='/modelli-esposti?pagina=1' tabindex=\"5\" accesskey=\"e\">Modelli esposti</a></li>",$header);
        $header = str_replace("LINKBIGLIETTI","<li><a href='/biglietti' tabindex=\"6\" accesskey=\"b\">Biglietti</a></li>",$header);
        $header = str_replace("LINKINFO","<li id='currentLink'>Info e Contatti</li>",$header);
        $header = str_replace("BREADCRUMBS","Info e Contatti",$header);
        echo $header;
        include '../pages/info-e-contatti.php';
        break;
    default:
        break;
}
include '../../html/common/footer.html';
?>
