<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "phpqrcode" . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . "qrlib.php";

use Database\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Exception.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "PHPMailer.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "SMTP.php";

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
    ['id' => 'email', 'regexp' => '/^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/', 'output' => 'Il campo Email inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'comune', 'regexp' => '/^[a-zA-Z]{1,15}$/', 'output' => 'Il campo Comune inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'citta', 'regexp' => '/^[a-zA-Z]{1,15}$/', 'output' => 'Il campo Città inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'indirizzo', 'regexp' => '/^[a-zA-Z]{1,10}\s[a-zA-Z]{1,30}\s[0-9]{1,4}$/', 'output' => 'Il campo Indirizzo inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'stato', 'regexp' => $regexpStati, 'output' => 'Il campo Stato selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati.'],
    ['id' => 'nbiglietti', 'regexp' => '/^[' . MINBIGLIETTI . '-' . MAXBIGLIETTI . ']$/', 'output' => 'Il numero di biglietti selezionato non è tra quelli indicati. Selezionarlo tra quelli indicati.']
];

$dateFields = [
    ['id' => 'giornonascita', 'label' => 'Giorno di nascita'],
    ['id' => 'mesenascita', 'label' => 'Mese di nascita'],
    ['id' => 'annonascita', 'label' => 'Anno di nascita'],
    ['id' => 'giornomostra', 'label' => 'Giorno della mostra'],
    ['id' => 'mesemostra', 'label' => 'Mese della mostra'],
    ['id' => 'annomostra', 'label' => 'Anno della mostra']
];

function validazione($input, $value, &$page) {
    $page = str_replace("*" . $input['id'] . "*", $_POST[$input['id']], $page);
    if (!preg_match($input['regexp'], $value)) {
        $page = str_replace("*error" . $input['id'] . "*", '<p class="col4 error">' . $input['output'] . '</p>', $page);
        return false;
    } else {
        $page = str_replace("*error" . $input['id'] . "*", '', $page);
        return true;
    }
}

function checkData($giorno, $mese, $anno) {
    $data = $anno . '-' . $mese . '-' . $giorno;
    if (preg_match('/^[1|2][0-9]{3,3}-([1-9]|1[0|1|2])-([1-9]|[1|2][0-9]|3[0|1])$/', $data)) {
        if ($giorno == 31 && ($mese == 4 || $mese == 6 || $mese == 9 || $mese == 11))
            return false;
        if ($giorno > 29 && $mese == 2)
            return false;
        if ($giorno == 29 && $mese == 2 && !($anno % 4 == 0 && ($anno % 100 != 0 || $anno % 400 == 0)))
            return false;
        return true;
    }
    return false;
}

function checkBoundLimit($element, $min, $max) {
    return $min <= $element && $element <= $max;
}

function createOptionsNumber($id, $min, $max) {
    $options = "";
    for ($i = $min; $i <= $max; $i++) {
        $options .= "<option value=\"$i\"";
        if (!empty($_POST["$id"]) && $_POST["$id"] == $i)
            $options .= " selected=\"selected\"";
        $options .= ">";
        if ($id == "mesenascita" || $id == "mesemostra")
            $options .= createMese($i);
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

function loadDataMostre($database) {
    $mostredb = array_merge(Database::selectEvents("corrente", 1), Database::selectEvents("futuro", 2));
    foreach ($mostredb as $mostra)
        $mostre[] = $mostra;
    return $mostre;
}

$database = new Database();
if ($database) {
    $page = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "biglietti.html");
    
    if (isset($_POST['invio'])) {
        
        foreach ($inputs as $input) {
            if (!isset($_POST[$input['id']]) || empty($_POST[$input['id']])) {
                $page = str_replace("*error" . $input['id'] . "*", "<p class=\"col4 error\">Il campo " . $input['id'] . " è richiesto. Si prega di inserirlo.</p>", $page);
            }
        }

        foreach ($dateFields as $selector) {
            if (!isset($_POST[$selector['id']]) || empty($_POST[$selector['id']])) {
                $page = str_replace("*error" . $selector['id'] . "*", "<p class=\"col4 error\">Il campo " . $selector['label'] . " è richiesto. Si prega di inserirlo.</p>", $page);
            }
        }

        $page = str_replace("*stato*", createStati($stati), $page);
        $page = str_replace("*nbiglietti*", createOptionsNumber('nbiglietti', MINBIGLIETTI, MAXBIGLIETTI), $page);

        foreach ($inputs as $input)
            $check[] = validazione($input, $_POST[$input['id']], $page);

        if (checkData($_POST['giornonascita'], $_POST['mesenascita'], $_POST['annonascita'])) {
            if (!checkBoundLimit(strtotime($_POST['annonascita'] . '-' . $_POST['mesenascita'] . '-' . $_POST['giornonascita']), strtotime(MINANNONASCITA . "-1-1"), strtotime(MAXANNONASCITA . "-12-31"))) {
                $page = str_replace("*errordatanascita*", "<p class=\"col4 error\">La data di nascita deve rispettare i limiti proposti. Si prega di correggerla.</p>", $page);
                $check[] = false;
            }
        } else {
            $page = str_replace("*errordatanascita*", "<p class=\"col4 error\">La data di nascita non è coerente. Non esiste il giorno indicato nel mese indicato. Si prega di correggere la data.</p>", $page);
            $check[] = false;
        }

        if (!checkData($_POST['giornomostra'], $_POST['mesemostra'], $_POST['annomostra'])) {
            $page = str_replace("*errordatamostra*", "<p class=\"col4 error\">La data della mostra non è coerente. Non esiste il giorno indicato nel mese indicato. Si prega di correggere la data.</p>", $page);
            $check[] = false;
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
                $mail = new PHPMailer(true);
                if (isset($mail)) {
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'museoferrariunipd@gmail.com';
                        $mail->Password = 'museoferrariunipd/tecweb';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        $mail->setFrom('museoferrariunipd@gmail.com', 'Museo Ferrari');
                        $mail->addAddress($_POST['email'], $_POST['nome'] . ' ' . $_POST['cognome']);
                        $mail->addCC('museoferrariunipd@gmail.com');
                        $qrcode = $user['ID'] . $_POST['mostra'] . $_POST['annomostra'] . $_POST['mesemostra'] . $_POST['giornomostra'] . $_POST['nbiglietti'];

                        $tmpdir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR;

                        QRCode::png($qrcode, $tmpdir . $_POST['email'] . ".png", QR_ECLEVEL_L, 3);

                        $mail->addAttachment($tmpdir . $_POST['email'] . ".png", 'QR-code-prenotazione.png');

                        $mail->CharSet = 'UTF-8';
                        $mail->Encoding = 'base64';
                        $mail->Subject = 'Prenotazione effettuata';
                        $mail->Body = "Buongiorno " . $_POST['nome'] . " " . $_POST['cognome'] . ",\n\n"
                                . "Le comunichiamo che la sua prenotazione "
                                . "è stata effettuata con successo.\n\n"
                                . "Dati della prenotazione:\n"
                                . "Mostra - " . $mostre[$_POST['mostra']]['Titolo'] . "\n"
                                . "Data della mostra - " . $_POST['giornomostra'] . " " . createMese($_POST['mesemostra'])
                                . " " . $_POST['annomostra'] . "\n"
                                . "Biglietti prenotati - " . $_POST['nbiglietti'] . "\n\n"
                                . "Potrà procedere al pagamento direttamente alle casse del museo, presentando la stampa della prenotazione o il codice in allegato.\n\n"
                                . "Cordiali saluti"
                                . "-- \n"
                                . "Museo Ferrari";

                        $mail->send();
                    } catch (Exception $e) {
                        $error = true;
                    } finally {
                        unlink($tmpdir . $_POST['email'] . ".png");
                        if (!$error) {
                            $page = str_replace("*status*", "<p class=\"col-4 status\">La sua prenotazione è stata inviata correttamente. Controlli la sua casella di posta elettronica.</p>", $page);
                            $page = str_replace("*disabled*", "disabled=\"disabled\"", $page);
                        }
                    }
                } else
                    $error = true;
            } else
                $error = true;
        } else
            $error = false;

        if ($error)
            $page = str_replace("*status*", "<p class=\"col-4 error\">Si è verificato un errore nell'invio della prenotazione. La preghiamo di contattarci usando l'apposito <a href=\"/info-e-contatti#form\">form di contatto</a></p>", $page);
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
    $page = str_replace("*errorgiornonascita*", "", $page);
    $page = str_replace("*errormesenascita*", "", $page);
    $page = str_replace("*errorannonascita*", "", $page);

    $page = str_replace("*stato*", createStati($stati), $page);
    $page = str_replace("*errorstato*", "", $page);

    $datamostre = loadDataMostre($database);
    createMostre($datamostre, $page);
    $page = str_replace("*errormostra*", "", $page);
    $page = str_replace("*errordatamostra*", "", $page);
    $page = str_replace("*errorgiornomostra*", "", $page);
    $page = str_replace("*errormesemostra*", "", $page);
    $page = str_replace("*errorannomostra*", "", $page);

    $page = str_replace("*nbiglietti*", createOptionsNumber('nbiglietti', MINBIGLIETTI, MAXBIGLIETTI), $page);
    $page = str_replace("*errornbiglietti*", "", $page);

    if (!empty($_POST['newsletter']))
        $page = str_replace("*newsletter*", "checked=\"checked\"", $page);
    $page = str_replace("*newsletter*", "", $page);

    $page = str_replace("*status*", "", $page);

    $page = str_replace("*disabled*", "", $page);

    echo $page;
}