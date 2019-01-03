<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";

use Database\Database;

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

function createSelectableNumber($id, $min, $max) {
    $options = "";
    for ($i = $min; $i <= $max; $i++) {
        $options .= "<option value=\"$i\"";
        if (!empty($_POST["$id"]) && $_POST["$id"] == $i) {
            $options .= " selected=\"selected\"";
        }
        $options .= ">";
        if ($id == "mesenascita" || $id=="mesemostra")
            $options .= createMese($i);
        else
            $options .= $i;
        $options .= "</option>";
    }
    return $options;
}

function createMese($n) {
    switch ($n) {
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
    $mostredb = array_merge(Database::selectEvents("corrente", 1), Database::selectEvents("futuro", 2));
    $mostre = "";
    $anni = "";
    $mesi = "";
    $giorni = "";
    $dataold = "";
    $datanew = "";
    foreach ($mostredb as $mostra) {
        $mostre .= '<option value="' . $mostra['ID'] . '"';
        if(!empty($_POST["mostra"]) && $_POST["mostra"] == $mostra['ID']){
            $mostre.=" selected=\"selected\"";
        }
        $mostre.='>' . $mostra['Titolo'] . '</option>';
        if (empty($dataold)) {
            $dataold = $mostra['DataInizio'];
            $datanew = $mostra['DataFine'];
        }
        if ($mostra['DataInizio'] < $dataold)
            $dataold = $mostra['DataInizio'];
        if ($mostra['DataFine'] > $datanew)
            $datanew = $mostra['DataFine'];
    }
    $dataold = strtotime($dataold);
    $datanew = strtotime($datanew);
    $now = strtotime("now");
    if ($dataold < $now)
        $dataold = $now;
    if ($dataold < $datanew) {
        $page = str_replace("*annimostre*", createSelectableNumber("annomostra", date('Y', $dataold), date('Y', $datanew)), $page);

        if (date('Y', $dataold) == date('Y', $datanew)) {
            $page = str_replace("*mesimostre*", createSelectableNumber("mesemostra", date('m', $dataold), date('m', $datanew)), $page);
        } else {
            $page = str_replace("*mesimostre*", createSelectableNumber("mesemostra", 1, 12), $page);
        }
        if (date('m', $dataold) == date('m', $datanew)) {
            $page = str_replace("*giornimostre*", createSelectableNumber("giornomostra", date('d', $dataold), date('d', $datanew)), $page);
        } else {
            $page = str_replace("*giornimostre*", createSelectableNumber("giornomostra", 1, 31), $page);
        }
    }
    $page = str_replace("*nbiglietti*", createSelectableNumber("nbiglietti", 1, 8), $page);
    $page = str_replace("*mostre*", $mostre, $page);
}

function checkField($id, &$page, $type) {
    $checked = false;
    if (!empty($_POST["$id"])) {
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
    }
    if (is_bool($checked)) {
        $page = str_replace("*error$id*", "<p class=\"col-4 error\">Il campo " . ucfirst($id) . " inserito non è corretto. Rispettare il formato indicato.</p>", $page);
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
        if (!empty($_POST['giornonascita']) && !empty($_POST['mesenascita']) && !empty($_POST['annonascita']))
            $check['datanascita'] = checkdate($_POST['mesenascita'], $_POST['giornonascita'], $_POST['annonascita']);
        $check['comune'] = checkField("comune", $page, 's');
        $check['telefono'] = checkField("telefono", $page, 'n');
        $check['email'] = checkField("email", $page, 'e');
        $check['indirizzo'] = checkField("indirizzo", $page, 'a');
        $check['citta'] = checkField("citta", $page, 's');
        if (!empty($_POST['giornomostra']) && !empty($_POST['mesemostra']) && !empty($_POST['annomostra']))
            $check['datamostra'] = checkdate($_POST['mesemostra'], $_POST['giornomostra'], $_POST['annomostra']);

        if (!$check['datanascita'])
            $page = str_replace("*errordatanascita*", "<p class=\"col-4 error\">La data di nascita inserita non è corretta. Immettere una data valida.</p>", $page);
        if (!$check['datamostra'])
            $page = str_replace("*errormostra*", "<p class=\"col-4 error\">La data inserita non è corretta. Immettere una data valida.</p>", $page);
    }
    $page = str_replace("*nome*", "", $page);
    $page = str_replace("*errornome*", "", $page);
    $page = str_replace("*cognome*", "", $page);
    $page = str_replace("*errorcognome*", "", $page);
    $page = str_replace("*comune*", "", $page);
    $page = str_replace("*errorcomune*", "", $page);
    $page = str_replace("*telefono*", "", $page);
    $page = str_replace("*errortelefono*", "", $page);
    
    $stati="";
    $statiarray = array();
    $statiarray['fr']='France';
    $statiarray['it']='Italia';
    $statiarray['uk']='United Kingdom';
    foreach($statiarray as $key=>$stato){
        $stati .= '<option value="' . $key . '"';
        if(!empty($_POST["stato"]) && $_POST["stato"] == $key){
            $stati.=" selected=\"selected\"";
        }
        $stati.='>' . $stato . '</option>';
    }
    $page = str_replace("*stato*", $stati, $page);
    $page = str_replace("*email*", "", $page);
    $page = str_replace("*erroremail*", "", $page);
    $page = str_replace("*errorstato*", "", $page);
    $page = str_replace("*indirizzo*", "", $page);
    $page = str_replace("*errorindirizzo*", "", $page);
    $page = str_replace("*citta*", "", $page);
    $page = str_replace("*errorcitta*", "", $page);
    $page = str_replace("*errordatanascita*", "", $page);
    $page = str_replace("*errordatamostra*", "", $page);

    $page = str_replace("*annonascita*", createSelectableNumber("annonascita", date("Y") - 100, date('Y') - 14), $page);
    $page = str_replace("*mesenascita*", createSelectableNumber("mesenascita", 1, 12), $page);
    $page = str_replace("*giornonascita*", createSelectableNumber("giornonascita", 1, 31), $page);
    loadmostre($database, $page);
    echo $page;
}