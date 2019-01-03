<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";

use Database\Database;

function checkExists($field) {
    return !isset($field) || empty($field);
}

function checkAlpha($string) {
    if (ctype_alpha($string))
        return ucfirst(strtolower($string));
    return false;
}

function checkNumeric($number) {
    if (ctype_digit($number))
        return $number;
    return false;
}

function checkAddress($string) {
    if (ctype_alnum($string) && !ctype_digit($string))
        return ucfirst(strtolower($string));
    return false;
}

function createAnniNascita() {
    $anni = "";
    for ($i = date("Y") - 100; $i < date("Y"); $i++) {
        $anni .= "<option value=\"$i\">" . $i . "</option>";
    }
    return $anni;
}

function createMese($n){
    switch($n){
        case 1:
            return "Gennaio";
        case 2:
            return "Febbraio";
        case 3:
            return "Marzo";
        case 4:
            return "Aprile";
        case 5:
            return "Maggio";
        case 6:
            return "Giugno";
        case 7:
            return "Luglio";
        case 8:
            return "Agosto";
        case 9:
            return "Settembre";
        case 10:
            return "Ottobre";
        case 11:
            return "Novembre";
        case 12:
            return "Dicembre";
    }
}

function loadMostre($database, &$page) {
    $mostredb = array_merge(Database::selectEvents("corrente", 1),Database::selectEvents("futuro", 2));
    $mostre="";
    $anni="";
    $mesi="";
    $giorni="";
    $dataold = "";
    $datanew = "";
    foreach ($mostredb as $mostra) {
        $mostre .= '<option value="' . $mostra['Titolo'] . '">' . $mostra['Titolo'] . '</option>';
        if (empty($dataold)) {
            $dataold = $mostra['DataInizio'];
            $datanew = $mostra['DataFine'];
        } else {
            if ($mostra['DataInizio'] < $dataold)
                $dataold = $mostra['DataInizio'];
            if ($mostra['DataFine'] > $datanew)
                $datanew = $mostra['DataFine'];
        }
    }
    $dataold = strtotime($dataold);
    $datanew = strtotime($datanew);
    for($i=date('Y',$dataold);$i<=date('Y',$datanew);$i++){
        $anni.="<option value=\"$i\">$i</option>";
    }
    if(date('Y',$dataold)==date('Y',$datanew)){
        for($i=date('m',$dataold);$i<=date('m',$datanew);$i++){
            $mesi.="<option value=\"$i\">".createMese($i)."</option>";
        }
    }
    else{
        for($i=1;$i<=12;$i++){
            $mesi.="<option value=\"$i\">".createMese($i)."</option>";
        }
    }
    if(date('m',$dataold)==date('m',$datanew)){
        for($i=date('d',$dataold);$i<=date('d',$datanew);$i++){
            $giorni.="<option value=\"$i\">$i</option>";
        }
    }
    else{
        for($i=1;$i<=31;$i++){
            $giorni.="<option value=\"$i\">$i</option>";
        }
    }
    $page= str_replace("*mostre*", $mostre, $page);
    $page= str_replace("*annimostre*", $anni, $page);
    $page= str_replace("*mesimostre*", $mesi, $page);
    $page= str_replace("*giornimostre*", $giorni, $page);
}

function checkField($id, &$page, $type) {
    switch ($type) {
        case 's':
            $checked = checkAlpha($_POST["$id"]);
            break;
        case 'a':
            $checked = checkAddress($_POST["indirizzo"]);
            break;
        case 'n':
            $checked = checkNumeric($_POST["$id"]);
            break;
        case 'e':
            $checked = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
            break;
    }
    if (checkExists($_POST["$id"]) || is_bool($checked)) {
        $page = str_replace("*error$id*", "<p class=\"col-4 error\">Il campo $id inserito non è corretto. Rispettare il formato indicato.</p>", $page);
        $page = str_replace("*$id*", $_POST["$id"], $page);
        return false;
    }
    $page = str_replace("*$id*", $checked, $page);
    return true;
}

$database = new Database();
if ($database) {
    $page = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "biglietti.html");
    $check = array();
    if (isset($_POST['invio'])) {
        $check['nome'] = checkField("nome", $page, 's');
        $check['cognome'] = checkField("cognome", $page, 's');
        $check['comune'] = checkField("comune", $page, 's');
        $check['telefono'] = checkField("telefono", $page, 'n');
        $check['email'] = checkField("email", $page, 'e');
        $check['indirizzo'] = checkField("indirizzo", $page, 'a');
        $check['citta'] = checkField("citta", $page, 'a');
    }
    $page = str_replace("*nome*", "", $page);
    $page = str_replace("*errornome*", "", $page);
    $page = str_replace("*cognome*", "", $page);
    $page = str_replace("*errorcognome*", "", $page);
    $page = str_replace("*comune*", "", $page);
    $page = str_replace("*errorcomune*", "", $page);
    $page = str_replace("*telefono*", "", $page);
    $page = str_replace("*errortelefono*", "", $page);
    $page = str_replace("*email*", "", $page);
    $page = str_replace("*erroremail*", "", $page);
    $page = str_replace("*errorstato*", "", $page);
    $page = str_replace("*indirizzo*", "", $page);
    $page = str_replace("*errorindirizzo*", "", $page);
    $page = str_replace("*citta*", "", $page);
    $page = str_replace("*errorcitta*", "", $page);

    $page = str_replace("*anninascita*", createAnniNascita(), $page);
    loadmostre($database,$page);
    echo $page;
}