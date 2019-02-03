<?php

$footer = file_get_contents("../../html/common/footer.html");
$last_uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$last_uri_parts[0] = substr($last_uri_parts[0], strrpos($last_uri_parts[0], '/')+1);
/*
//se bisogna mettere il tabindex sul bottone to top
if ($counter > 0) checkCounter($counter,$tabIndex);
$footer = str_replace("*bottonetotop*","<a href=\"#header\" tabindex=\"$tabIndex\"><div id=\"totop\"></div></a>",$footer);
*/
//altrimenti
$footer = str_replace("*bottonetotop*","<a href=\"#header\"><div id=\"totop\"></div></a>",$footer);

switch ($last_uri_parts[0]){
    case "biglietti":
		$footer = str_replace("*scriptbiglietti*",'<script type="text/javascript" src="./js/biglietti.js"></script>',$footer);
		break;
	default:
		$footer = str_replace("*scriptbiglietti*",'',$footer);
		break;
}
echo $footer;