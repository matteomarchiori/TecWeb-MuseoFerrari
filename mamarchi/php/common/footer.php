<?php

require_once "utilities.php";
use Utilities\Utilities;

$footer = file_get_contents(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."html".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."footer.html");
$last_uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$last_uri_parts[0] = substr($last_uri_parts[0], strrpos($last_uri_parts[0], '/')+1);

if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
$footer = str_replace("*bottonetotop*","<p><a href=\"#header\" tabindex=\"$tabIndex\"><span id=\"totop\">Torna su</span></a></p>",$footer,$counter);


switch ($last_uri_parts[0]){
    case "modelli-esposti":
        $footer = str_replace("*script*",'<script type="text/javascript" src="./js/modelli-esposti.js"></script>',$footer);
		break;
    case "biglietti":
		$footer = str_replace("*script*",'<script type="text/javascript" src="./js/biglietti.js"></script>',$footer);
		break;
	case "info-e-contatti":
		$footer = str_replace("*script*",'<script type="text/javascript" src="./js/info-e-contatti.js"></script>',$footer);
		break;
	default:
		$footer = str_replace("*script*",'<script type="text/javascript" src="./js/header.js"></script>',$footer);
		break;
}
echo $footer;