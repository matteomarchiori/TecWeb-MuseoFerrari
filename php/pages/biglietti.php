<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";

use Database\Database;

define("MINANNONASCITA", date("Y") - 100);
define("MAXANNONASCITA", date("Y") - 14);
define("MINBIGLIETTI", 1);
define("MAXBIGLIETTI", 8);

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

function checkText($id, &$page, $type) {
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

function checkBoundLimit($date, $min, $max) {
    return $min <= $date && $date <= $max;
}

function createOptionsNumber($id, &$page, $min, $max) {
    $options = "";
    $flag = false;
    for ($i = $min; $i <= $max; $i++) {
        $options .= "<option value=\"$i\"";
        if (!empty($_POST["$id"]) && $_POST["$id"] == $i) {
            $options .= " selected=\"selected\"";
            $flag = true;
        }
        $options .= ">";
        if ($id == "mesenascita" || $id == "mesemostra")
            $options .= createMese($i);
        else
            $options .= $i;
        $options .= "</option>";
    }
    if (!empty($_POST["$id"]) && !$flag) {
        switch ($id) {
            case "annonascita":
                $page = str_replace("*errorannonascita*", "<p class=\"col-4 error\">Controlla l'anno di nascita. L'anno inviato non era in elenco.</p>", $page);
                break;
            case "mesenascita":
                $page = str_replace("*errormesenascita*", "<p class=\"col-4 error\">Controlla il mese di nascita inserito. Il mese inviato non era in elenco.</p>", $page);
                break;
            case "giornonascita":
                $page = str_replace("*errorgiornonascita*", "<p class=\"col-4 error\">Controlla il giorno di nascita inserito. Il giorno inviato non era in elenco.</p>", $page);
                break;
            case "annomostra":
                $page = str_replace("*errorannomostra*", "<p class=\"col-4 error\">Controlla l'anno della mostra inserito. L'anno inviato non era in elenco.</p>", $page);
                break;
            case "mesemostra":
                $page = str_replace("*errormesemostra*", "<p class=\"col-4 error\">Controlla il mese della mostra inserito. Il mese inviato non era in elenco.</p>", $page);
                break;
            case "giornomostra":
                $page = str_replace("*errorgiornomostra*", "<p class=\"col-4 error\">Controlla il giorno della mostra inserito.</p>", $page);
                break;
            case "nbiglietti":
                $page = str_replace("*errornbiglietti*", "<p class=\"col-4 error\">Controlla il numero di biglietti  inserito. Il numero inviato non era in elenco.</p>", $page);
                break;
        }
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

function createStati(){
    $statiarray = array();
    $statiarray['fr'] = 'France';
    $statiarray['it'] = 'Italia';
    $statiarray['uk'] = 'United Kingdom';
    
    return $statiarray;
}

function loadDataMostre($database, &$mostre, &$dataold, &$datanew) {
    $mostredb = array_merge(Database::selectEvents("corrente", 1), Database::selectEvents("futuro", 2));
    $mostre = array();
    foreach ($mostredb as $mostra) {
        $mostre[$mostra['ID']] = $mostra['Titolo'];
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
}

function loadMostre($database, &$page) {
    $mostre = "";
    $anni = "";
    $mesi = "";
    $giorni = "";
    $dataold = "";
    $datanew = "";
    loadDataMostre($database, $mostrearray, $dataold, $datanew);
    $flag = false;
    foreach ($mostrearray as $id => $mostra) {
        $mostre .= '<option value="' . $id . '"';
        if (!empty($_POST["mostra"]) && $_POST["mostra"] == $id) {
            $flag = true;
            $mostre .= " selected=\"selected\"";
        }
        $mostre .= '>' . $mostra . '</option>';
    }
    if(!empty($_POST["mostra"]) && !$flag){
        $page = str_replace("*errormostra*", "<p class=\"col-4 error\">Controlla la mostra selezionata. La mostra inviata non era in elenco.</p>", $page);
    }
    if ($dataold < $datanew) {
        $page = str_replace("*annimostre*", createOptionsNumber("annomostra", $page, date('Y', $dataold), date('Y', $datanew)), $page);

        if (date('Y', $dataold) == date('Y', $datanew)) {
            $page = str_replace("*mesimostre*", createOptionsNumber("mesemostra", $page, date('m', $dataold), date('m', $datanew)), $page);
        } else {
            $page = str_replace("*mesimostre*", createOptionsNumber("mesemostra", $page, 1, 12), $page);
        }
        if (date('m', $dataold) == date('m', $datanew)) {
            $page = str_replace("*giornimostre*", createOptionsNumber("giornomostra", $page, date('d', $dataold), date('d', $datanew)), $page);
        } else {
            $page = str_replace("*giornimostre*", createOptionsNumber("giornomostra", $page, 1, 31), $page);
        }
    }
    $page = str_replace("*nbiglietti*", createOptionsNumber("nbiglietti", $page, MINBIGLIETTI, MAXBIGLIETTI), $page);
    $page = str_replace("*mostre*", $mostre, $page);
}

$database = new Database();
if ($database) {
    $page = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "biglietti.html");
    $check = array();
    if (isset($_POST['invio'])) {
        $check['nome'] = checkText("nome", $page, 's');
        $check['cognome'] = checkText("cognome", $page, 's');
        if (!empty($_POST['giornonascita']) && !empty($_POST['mesenascita']) && !empty($_POST['annonascita'])) {
            $check['datanascita'] = checkdate($_POST['mesenascita'], $_POST['giornonascita'], $_POST['annonascita']);
            if ($check['datanascita']) {
                $check['datanascita'] = checkBoundLimit(strtotime($_POST['annonascita'] . '-' . $_POST['mesenascita'] . '-' . $_POST['giornonascita']), strtotime(MINANNONASCITA . "-1-1"), strtotime(MAXANNONASCITA . "-12-31"));
            }
        } else
            $check['datanascita'] = false;
        if (!$check['datanascita'])
            $page = str_replace("*errordatanascita*", "<p class=\"col-4 error\">La data inserita non è corretta. Immettere una data valida.</p>", $page);
        $check['comune'] = checkText("comune", $page, 's');
        $check['telefono'] = checkText("telefono", $page, 'n');
        $check['email'] = checkText("email", $page, 'e');
        
        $stati="";
        $flag=false;
        foreach (createStati() as $key => $stato) {
            $stati .= '<option value="' . $key . '"';
            if (!empty($_POST["stato"]) && $_POST["stato"] == $key) {
                $flag = true;
                $stati .= " selected=\"selected\"";
            }
            $stati .= '>' . $stato . '</option>';
        }
        $page = str_replace("*stato*", $stati, $page);
        if (!empty($_POST['stato']) && !$flag) {
            $page = str_replace("*errorstato*", "<p class=\"col-4 error\">Lo stato inserito non è corretto. Sceglierlo tra quelli in elenco.</p>", $page);
        }
        $check['stato']=$flag;
        
        $check['indirizzo'] = checkText("indirizzo", $page, 'a');
        $check['citta'] = checkText("citta", $page, 's');
        if (!empty($_POST['giornomostra']) && !empty($_POST['mesemostra']) && !empty($_POST['annomostra'])) {
            $check['datamostra'] = checkdate($_POST['mesemostra'], $_POST['giornomostra'], $_POST['annomostra']);
            if ($check['datamostra']) {
                loadDataMostre($database, $mostre, $dataold, $datanew);
                $check['datamostra'] = checkBoundLimit(strtotime($_POST['annomostra'] . '-' . $_POST['mesemostra'] . '-' . $_POST['giornomostra']), $dataold, $datanew);
            }
        } else
            $check['datamostra'] = false;
        if (!$check['datamostra'])
            $page = str_replace("*errordatamostra*", "<p class=\"col-4 error\">La data inserita non è corretta. Immettere una data valida.</p>", $page);
        if (!empty($_POST['nbiglietti']))
            $check['nbiglietti'] = checkBoundLimit($_POST['nbiglietti'], MINBIGLIETTI, MAXBIGLIETTI);
        else
            $check['nbiglietti'] = false;
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
    foreach (createStati() as $key => $stato) {
        $stati .= "<option value=\"$key\">$stato</option>";
    }
    
    $page = str_replace("*stato*", $stati, $page);
    $page = str_replace("*email*", "", $page);
    $page = str_replace("*erroremail*", "", $page);
    $page = str_replace("*errorstato*", "", $page);
    $page = str_replace("*indirizzo*", "", $page);
    $page = str_replace("*errorindirizzo*", "", $page);
    $page = str_replace("*citta*", "", $page);
    $page = str_replace("*errorcitta*", "", $page);

    $page = str_replace("*annonascita*", createOptionsNumber("annonascita", $page, MINANNONASCITA, MAXANNONASCITA), $page);
    $page = str_replace("*mesenascita*", createOptionsNumber("mesenascita", $page, 1, 12), $page);
    $page = str_replace("*giornonascita*", createOptionsNumber("giornonascita", $page, 1, 31), $page);
    $page = str_replace("*errordatanascita*", "", $page);
    $page = str_replace("*errorgiornonascita*", "", $page);
    $page = str_replace("*errormesenascita*", "", $page);
    $page = str_replace("*errorannonascita*", "", $page);
    loadmostre($database, $page);
    $page = str_replace("*errormostra*", "", $page);
    $page = str_replace("*errordatamostra*", "", $page);
    $page = str_replace("*errorgiornomostra*", "", $page);
    $page = str_replace("*errormesemostra*", "", $page);
    $page = str_replace("*errorannomostra*", "", $page);
    $page = str_replace("*errornbiglietti*", "", $page);
    if (!empty($_POST['newsletter'])) {
        $page = str_replace("*newsletter*", "checked=\"checked\"", $page);
    }
    echo $page;
}