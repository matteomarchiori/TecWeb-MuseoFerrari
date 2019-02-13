<?php
require_once "utilities.php";
use Utilities\Utilities;

$header = file_get_contents(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."html".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."header.html");
$last_uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$last_uri_parts[0] = substr($last_uri_parts[0], strrpos($last_uri_parts[0], '/')+1);

switch ($last_uri_parts[0]){
    case "":
        $header = str_replace("*title*","Homepage | Museo Ferrari",$header);
        $header = str_replace("*description*","L'homepage del museo presenta l'ultima Ferrari 250 Testa Rossa entrata in esposizione, una breve decrizione del museo e una sezione dedicata alle collezioni in esposizione prossimamente.",$header);
        $header = str_replace("*keywords*","Ferrari,esposizione,museo,programma",$header);
        $header = str_replace("*linkhome*","<li id='currentLink'><span xml:lang='en'>Home</span></li>",$header);
        $header = str_replace("*breadcrumbs*","<span xml:lang='en'>Home</span>",$header);
		$page = dirname(__DIR__).DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."home.php";
        break;
    case "mostre":
        $header = str_replace("*title*","Mostre | Museo Ferrari",$header);
        $header = str_replace("*description*","Nella pagina delle mostre è presente una descrizione della mostra Il cavallino degli anni '50 e l'elenco delle prossime mostre che si terranno al museo",$header);
        $header = str_replace("*keywords*","cavallino,mostre,museo",$header);
        $header = str_replace("*linkmostre*","<li id='currentLink'>Mostre</li>",$header);
        $header = str_replace("*breadcrumbs*","Mostre",$header);
        $page = dirname(__DIR__).DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."mostre.php";
        break;
    case "modelli-esposti":
        $header = str_replace("*title*","Modelli Esposti | Museo Ferrari",$header);
        $header = str_replace("*description*","Tutti i modelli Ferrari esposti della collezione del museo, con i dettagli relativi a motore, cilindrata, potenza ed esposizione nella mostra in corso.",$header);
        $header = str_replace("*keywords*","Ferrari,motore,cilindrata",$header);
        $header = str_replace("*linkmodelli*","<li id='currentLink'>Modelli esposti</li>",$header);
        $header = str_replace("*breadcrumbs*","Modelli Esposti",$header);
        $page = dirname(__DIR__).DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."modelli-esposti.php";
        break;
    case "biglietti":
        $header = str_replace("*title*","Biglietti | Museo Ferrari",$header);
        $header = str_replace("*description*","In questa pagina è possibile prenotare i biglietti per partecipare alle mostre  del museo. Il prezzo è di soli 15.00 € e i minori entrano gratis.",$header);
        $header = str_replace("*keywords*","biglietti,museo,mostre,gratis",$header);
        $header = str_replace("*linkbiglietti*","<li id='currentLink'>Biglietti</li>",$header);
        $header = str_replace("*breadcrumbs*","Biglietti",$header);
        $page = dirname(__DIR__).DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."biglietti.php";
        break;
    case "info-e-contatti":
        $header = str_replace("*title*","Info e Contatti | Museo Ferrari",$header);
        $header = str_replace("*description*","Qui vi sono le informazioni relative a come raggiungere il museo, i modi per contattarci e una mappa con la posizione del museo.",$header);
        $header = str_replace("*keywords*","informazioni,contatti,mappa,posizione",$header);
        $header = str_replace("*linkinfo*","<li id='currentLink'>Info e Contatti</li>",$header);
        $header = str_replace("*breadcrumbs*","Info e Contatti",$header);
        $page = dirname(__DIR__).DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."info-e-contatti.php";
        break;  
    default:
        $page = dirname(__DIR__).DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."not-found.php";
        break;
}

$tabIndex = 2;
$header = str_replace("*title*","Pagina non trovata",$header);
$header = str_replace("*breadcrumbs*","Pagina non trovata",$header);
$header = str_replace("*linkhome*","<li><a href='./' xml:lang='en' tabindex=\"$tabIndex\">Home</a></li>",$header,$counter);
if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
$header = str_replace("*linkmostre*","<li><a href='./mostre' tabindex=\"$tabIndex\">Mostre</a></li>",$header,$counter);
if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
$header = str_replace("*linkmodelli*","<li><a href='./modelli-esposti' tabindex=\"$tabIndex\">Modelli esposti</a></li>",$header,$counter);
if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
$header = str_replace("*linkbiglietti*","<li><a href='./biglietti' tabindex=\"$tabIndex\">Biglietti</a></li>",$header,$counter);
if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
$header = str_replace("*linkinfo*","<li><a href='./info-e-contatti' tabindex=\"$tabIndex\">Info e Contatti</a></li>",$header,$counter);
echo $header;
require_once $page;
require_once 'footer.php';