<?php

function checkField($field){
    return !isset($field) || empty($field);
}

function checkString($string){
    if(ctype_alpha($string))return ucfirst(strtolower($string));
    return false;
}

function checkText($id, &$page){
    $checked = checkString($_POST["$id"]);
    if(checkField($_POST["$id"]) || is_bool($checked)){
        $page = str_replace("*error$id*","<p class=\"col-4\">Il $id non è corretto. Rispettare il formato indicato.</p>",$page);
        $page = str_replace("*$id*",$_POST["$id"],$page);
    }
    else $page = str_replace("*$id*",$checked,$page);
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";

use Database\Database;

$database = new Database();
if ($database) {
    $page = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "biglietti.html");
    if (isset($_POST['invio'])) {
        checkText("nome", $page);
        checkText("cognome", $page);
        checkText("comune", $page);
        checkText("indirizzo", $page);
    }
    $page = str_replace("*nome*","",$page);
    $page = str_replace("*errornome*","",$page);
    $page = str_replace("*cognome*","",$page);
    $page = str_replace("*errorcognome*","",$page);
    
    
    echo $page;
}