<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "common" . DIRECTORY_SEPARATOR . "utilities.php";

use Utilities\Utilities;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "email" . DIRECTORY_SEPARATOR . "email.php";

use Email\Email;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "qrcode" . DIRECTORY_SEPARATOR . "qrcode.php";

use MyQRCode\MyQRCode;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";

use Database\Database;

define("MINANNONASCITA", date("Y") - 100);
define("MAXANNONASCITA", date("Y") - 18);
define("MINBIGLIETTI", 1);
define("MAXBIGLIETTI", 8);

$stati = [
    ['id' => 'it', 'nome' => 'Italia'],
    ['id' => 'fr', 'nome' => 'France'],
    ['id' => 'uk', 'nome' => 'United Kingdom']
];

$regexpStati = '/^';
$nstati = count($stati);
foreach ($stati as $k => $stato) {
    $regexpStati .= "[" . $stato['id'] . "]";
    if ($k != $nstati - 1)
        $regexpStati .= '|';
}
$regexpStati .= '$/';

$inputs = [
    ['id' => 'nome', 'regexp' => '/^[a-zA-Z]{1,15}$/', 'output' => 'Il campo Nome inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'cognome', 'regexp' => '/^[a-zA-Z]{1,15}$/', 'output' => 'Il campo Cognome inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'telefono', 'regexp' => '/^[0-9]{1,10}$/', 'output' => 'Il campo Telefono inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'email', 'regexp' => '/^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/', 'output' => 'Il campo <span xml:lang="en">Email</span> inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'comune', 'regexp' => '/^[a-zA-Z]{1,15}$/', 'output' => 'Il campo Comune inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'citta', 'regexp' => '/^[a-zA-Z]{1,15}$/', 'output' => 'Il campo Città inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'indirizzo', 'regexp' => '/^[a-zA-Z]{1,10}\\s[a-zA-Z\\s]{1,30}\\s[0-9]{1,4}$/', 'output' => 'Il campo Indirizzo inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'stato', 'regexp' => $regexpStati, 'output' => 'Il campo Stato selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati.'],
    ['id' => 'nbiglietti', 'regexp' => '/^[' . MINBIGLIETTI . '-' . MAXBIGLIETTI . ']$/', 'output' => 'Il numero di biglietti selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati.']
];

function checkDataMostra($mostra, $data) {
    $db = Database::selectEventById($mostra);
    $dataInizio = $db['DataInizio'];
    $dataFine = $db['DataFine'];
    $inizio = strtotime($dataInizio);
    $adesso = strtotime("now");
    if ($adesso < $inizio)
        $inizio = $adesso;
    return Utilities::checkBoundLimit(strtotime($data), $inizio, strtotime($dataFine));
}

function createOptionsNumber($id, $min, $max) {
    $options = "";
    for ($i = $min; $i <= $max; $i++) {
        $options .= "<option value=\"$i\"";
        if (!empty($_POST["$id"]) && $_POST["$id"] == $i)
            $options .= " selected=\"selected\"";
        $options .= ">";
        if ($id == "mesenascita" || $id == "mesemostra")
            $options .= Utilities::getMonthName($i);
        else
            $options .= $i;
        $options .= "</option>";
    }
    return $options;
}

function createStati($stati) {
    $options = "";
    foreach ($stati as $stato) {
        $options .= '<option value="' . $stato['id'] . '"';
        if (!empty($_POST["stato"]) && $_POST["stato"] == $stato['id'])
            $options .= " selected=\"selected\"";
        $options .= ">" . $stato['nome'] . "</option>";
    }
    return $options;
}

function createMostre($mostredb, &$page) {
    $mostre = "";
    foreach ($mostredb as $mostra) {
        $mostre .= '<option value="' . $mostra['ID'] . '"';
        if (!empty($_POST["mostra"]) && $_POST["mostra"] == $mostra['ID'])
            $mostre .= " selected=\"selected\"";
        $mostre .= ">" . $mostra['Titolo'] . "</option>";
    }
    $page = str_replace('*mostre*', $mostre, $page);
    $now = strtotime("now");
    $start = strtotime($mostredb[0]['DataInizio']);
    $end = strtotime($mostredb[2]['DataFine']);
    if ($now > $start)
        $start = $now;
    $startyear = date('Y', $start);
    $startmonth = date('n', $start);
    $startday = date('j', $start);
    $endyear = date('Y', $end);
    $endmonth = date('n', $end);
    $endday = date('j', $end);
    $anni = createOptionsNumber("annomostra", $startyear, $endyear);
    $mesi = createOptionsNumber("mesemostra", $startmonth, $endmonth);
    $giorni = createOptionsNumber("giornomostra", $startday, $endday);
    if ($startmonth != $endmonth) {
        $giorni = createOptionsNumber("giornomostra", 1, 31);
    }
    if ($startyear != $endyear) {
        $mesi = createOptionsNumber("mesemostra", 1, 12);
        $giorni = createOptionsNumber("giornomostra", 1, 31);
    }
    $page = str_replace('*annimostre*', $anni, $page);
    $page = str_replace('*mesimostre*', $mesi, $page);
    $page = str_replace('*giornimostre*', $giorni, $page);
}

function loadDataMostre($database) {
    $mostredb = array_merge(Database::selectEvents("corrente", 1), Database::selectEvents("futuro", 2));
    foreach ($mostredb as $mostra)
        $mostre[] = $mostra;
    return $mostre;
}

$database = new Database();
if ($database) {
    $page = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "biglietti.html");

    $tabindexes = ['nome','cognome','giornonascita','mesenascita','annonascita','telefono','email','stato','indirizzo','citta','mostra','giornomostra','mesemostra','annomostra','biglietti','newsletter','invio','reset'];
    foreach($tabindexes as $tabindice){
        if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
        $page = str_replace("*tabindex$tabindice*",$tabIndex,$page,$counter);
    }
    
    if (isset($_POST['invio'])) {

        Utilities::checkEmptyInputs($inputs, $page);

        $page = str_replace("*stato*", createStati($stati), $page);
        $page = str_replace("*nbiglietti*", createOptionsNumber('nbiglietti', MINBIGLIETTI, MAXBIGLIETTI), $page);

        foreach ($inputs as $input)
            $check[] = Utilities::validazione($input, $_POST[$input['id']], $page);

        if (Utilities::checkData($_POST['giornonascita'], $_POST['mesenascita'], $_POST['annonascita'])) {
            if (!Utilities::checkBoundLimit(strtotime($_POST['annonascita'] . '-' . $_POST['mesenascita'] . '-' . $_POST['giornonascita']), strtotime(MINANNONASCITA . "-1-1"), strtotime(MAXANNONASCITA . "-12-31"))) {
                $page = str_replace("*errordatanascita*", "<p class=\"col4 error\">La data di nascita deve rispettare i limiti proposti. Si prega di correggerla.</p>", $page);
                $check[] = false;
            }
        } else {
            $page = str_replace("*errordatanascita*", "<p class=\"col4 error\">La data di nascita non è coerente. Non esiste il giorno indicato nel mese indicato. Si prega di correggere la data.</p>", $page);
            $check[] = false;
        }

        if (!Utilities::checkData($_POST['giornomostra'], $_POST['mesemostra'], $_POST['annomostra'])) {
            $page = str_replace("*errordatamostra*", "<p class=\"col4 error\">La data della mostra non è coerente. Non esiste il giorno indicato nel mese indicato. Si prega di correggere la data.</p>", $page);
            $check[] = false;
        } else {
            if (!checkDataMostra($_POST['mostra'], $_POST['annomostra'] . '-' . $_POST['mesemostra'] . '-' . $_POST['giornomostra'])) {
                $page = str_replace("*errordatamostra*", "<p class=\"col4 error\">La data selezionata non rientra nel periodo della mostra selezionata. Si prega di correggere la data.</p>", $page);
                $check[] = false;
            }
        }

        if (in_array(false, $check) == false) {
            $error = false;
            $user = Database::selectUser($_POST['email']);
            if (empty($user)) {
                $registeruser = Database::registerUser($_POST['nome'], $_POST['cognome'], $_POST['annonascita'] . '-' . $_POST['mesenascita'] . '-' . $_POST['giornonascita'], $_POST['comune'], $_POST['telefono'], $_POST['email'], $_POST['stato'], $_POST['indirizzo'], $_POST['citta'], $_POST['newsletter']);
            }
            if (isset($registeruser) && $registeruser)
                $user = Database::selectUser($_POST['email']);
            $biglietto = Database::buyTickets($user['ID'], $_POST['mostra'], $_POST['annomostra'] . '-' . $_POST['mesemostra'] . '-' . $_POST['giornomostra'], $_POST['nbiglietti']);
            if (isset($user) && $biglietto) {
                $email = new Email();
                if (isset($email)) {
                    $subject = 'Prenotazione effettuata';
                    $message = "Buongiorno " . $_POST['nome'] . " " . $_POST['cognome'] . ",\n\n"
                            . "Le comunichiamo che la sua prenotazione "
                            . "è stata effettuata con successo.\n\n"
                            . "Dati della prenotazione:\n"
                            . "Mostra - " . Database::selectEventById($_POST['mostra'])['Titolo'] . "\n"
                            . "Data della mostra - " . $_POST['giornomostra'] . " " . Utilities::getMonthName($_POST['mesemostra'])
                            . " " . $_POST['annomostra'] . "\n"
                            . "Biglietti prenotati - " . $_POST['nbiglietti'] . "\n\n"
                            . "Potrà procedere al pagamento direttamente alle casse del museo, presentando la stampa della prenotazione o il codice in allegato.\n\n"
                            . "Cordiali saluti\n"
                            . "-- \n"
                            . "Museo Ferrari";
                    $to = $_POST['email'];
                    $toName = $_POST['nome'] . ' ' . $_POST['cognome'];

                    $toencode = $user['ID'] . $_POST['mostra'] . $_POST['annomostra'] . $_POST['mesemostra'] . $_POST['giornomostra'] . $_POST['nbiglietti'];
                    $attachment = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR . $_POST['email'] . ".png";
                    $attachmentName = 'QR-code-prenotazione.png';

                    $qrcode = new MyQRCode($toencode, $attachment);

                    if (isset($qrcode)) {
                        $qrcode->encode();
                        $error = !$email::sendEmailWithAttachment($subject, $message, $to, $toName, $attachment, $attachmentName);
                        unlink($attachment);
                        if (!$error)
                            $page = str_replace("*status*", "<p class=\"col-4 status\" id=\"status\">La sua prenotazione è stata inviata correttamente. Controlli la sua casella di posta elettronica.</p>", $page);
                        $page = str_replace("*disabled*", "disabled=\"disabled\"", $page);
                    } else
                        $error = true;
                } else
                    $error = true;
            } else
                $error = true;
        } else
            $error = false;

        if ($error) {
            if ($counter > 0)
                Utilities::checkCounter($counter, $tabIndex);
            $page = str_replace("*status*", "<p class=\"col-4 error\" id=\"status\">Si è verificato un errore nell'invio della prenotazione. La preghiamo di contattarci usando l'apposito <a tabindex='$tabIndex' href=\"./info-e-contatti#formContattaci\">form di contatto</a>.</p>", $page, $counter);
        }
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
    $page = str_replace("*indirizzo*", "", $page);
    $page = str_replace("*errorindirizzo*", "", $page);
    $page = str_replace("*citta*", "", $page);
    $page = str_replace("*errorcitta*", "", $page);

    $page = str_replace("*annonascita*", createOptionsNumber("annonascita", MINANNONASCITA, MAXANNONASCITA), $page);
    $page = str_replace("*mesenascita*", createOptionsNumber("mesenascita", 1, 12), $page);
    $page = str_replace("*giornonascita*", createOptionsNumber("giornonascita", 1, 31), $page);
    $page = str_replace("*errordatanascita*", "", $page);

    $page = str_replace("*stato*", createStati($stati), $page);
    $page = str_replace("*errorstato*", "", $page);

    $datamostre = loadDataMostre($database);
    createMostre($datamostre, $page);
    $page = str_replace("*errormostra*", "", $page);
    $page = str_replace("*errordatamostra*", "", $page);

    $page = str_replace("*nbiglietti*", createOptionsNumber('nbiglietti', MINBIGLIETTI, MAXBIGLIETTI), $page);
    $page = str_replace("*errornbiglietti*", "", $page);

    if (!empty($_POST['newsletter']))
        $page = str_replace("*newsletter*", "checked=\"checked\"", $page);
    $page = str_replace("*newsletter*", "", $page);

    $page = str_replace("*status*", "", $page);

    $page = str_replace("*disabled*", "", $page);

    echo $page;
}
