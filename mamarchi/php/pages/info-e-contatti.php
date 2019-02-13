<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "common" . DIRECTORY_SEPARATOR . "utilities.php";
use Utilities\Utilities;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "email" . DIRECTORY_SEPARATOR . "email.php";
use Email\Email;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
use Database\Database;

$inputsMessage = [
    ['id' => 'nome', 'regexp' => '/^[a-zA-Z]{1,15}$/', 'output' => 'Il campo Nome inserito non è corretto. Rispettare il formato indicato.'],
    ['id' => 'email', 'regexp' => '/^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/', 'output' => 'Il campo <span xml:lang="en">Email</span> inserito non è corretto. Rispettare il formato indicato.']
];

$inputNewsletter = ['id' => 'emailNewsletter', 'regexp' => '/^[a-zA-Z0-9.:_-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/', 'output' => 'Il campo <span xml:lang="en">Email</span> inserito non è corretto. Rispettare il formato indicato.'];

$database = new Database();
if ($database) {
    $info = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "info-e-contatti.html");
    
    $tabindexes = ['emailnewsletter','invianewsletter','resetnewsletter','mailto','tel','nome','email','testo','inviamessaggio','resetmessaggio'];
    foreach($tabindexes as $tabindice){
        if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
        $info = str_replace("*tabindex$tabindice*",$tabIndex,$info,$counter);
    }
    
    if (isset($_POST['inviaNewsletter'])) {
        
        Utilities::checkEmptyInput($inputNewsletter, $info);
        
        $check = Utilities::validazione($inputNewsletter, $_POST['emailNewsletter'], $info);

        if ($check) {
            $error = false;
            if (Database::newsletter($_POST['emailNewsletter'])){
                $email = new Email();
                if(isset($email)){
                    $subject = 'Iscrizione alla newsletter effettuata';
                    $message = "Buongiorno " . $_POST['emailNewsletter'] . ",\n\n"
                            . "Le comunichiamo che la sua iscrizione alla newsletter "
                            . "è stata effettuata con successo.\n\n"
                            . "Cordiali saluti\n"
                            . "-- \n"
                            . "Museo Ferrari";
                    $to = $_POST['emailNewsletter'];
                    $error = !$email::sendEmail($subject, $message, $to, "");
                    if(!$error)
                        $info = str_replace("*statusnewsletter*", "<p class=\"col-4 status\" id=\"statusNewsletter\">Grazie per esserti iscritto alla nostra newsletter.</p>", $info);
                }else
                    $error=true;
            }
            else
                $error = true;
        } else
            $error = false;
        if ($error)
            $info = str_replace("*statusnewsletter*", "<p class=\"col-4 error\" id=\"statusNewsletter\">L'iscrizione non è andata a buon fine oppure è stata fatta in precedenza. Contattaci tramite l'apposito <a href=\"./info-e-contatti#formContattaci\">form di contatto</a>.</p>", $info);
    }
    
    if (isset($_POST['inviaMessaggio'])) {
        
        Utilities::checkEmptyInputs($inputsMessage, $info);
        
        foreach ($inputsMessage as $input)
            $check[] = Utilities::validazione($input, $_POST[$input['id']], $info);
        
        if(isset($_POST['testo']))
            $info = str_replace("*testo*", $_POST['testo'], $info);

        if (in_array(false, $check) == false) {
            $error = false;
            $email = new Email();
            if (isset($email)) {
                $subject = 'Messaggio da parte di '.$_POST['nome'];
                $message = "Nome: ".$_POST['nome']."\n"
                        . "Email: ".$_POST['email']."\n\n"
                        . "Messaggio: ".$_POST['testo'];
                $to = "museoferrariunipd@gmail.com";
                $error = !$email::sendEmail($subject, $message, $to, "");
                if(!$error)
                        $info = str_replace("*statusmessaggio*", "<p class=\"col-4 status\" id=\"statusMessaggio\">Il messaggio è stato inviato correttamente.</p>", $info);
                $info = str_replace("*disabled*", "disabled=\"disabled\"", $info);
            }
        } else
            $error = false;
        if ($error)
            $info = str_replace("*statusmessaggio*", "<p class=\"col-4 error\" id=\"statusMessaggio\">Si è verificato un errore non previsto. Puoi sempre scrivere un'<span xml:lang=\"en\">email</span> a <a href='mailto:museoferrariunipd@gmail.com'>museoferrariunipd@gmail.com</a>.</p>", $info);
    }

    $info = str_replace("*statusnewsletter*", "", $info);
    $info = str_replace("*erroremailNewsletter*", "", $info);
    $info = str_replace("*statusmessaggio*", "", $info);
    $info = str_replace("*errornome*", "", $info);
    $info = str_replace("*erroremail*", "", $info);
    $info = str_replace("*disabled*", "", $info);
    $info = str_replace("*nome*", "", $info);
    $info = str_replace("*email*", "", $info);
    $info = str_replace("*testo*", "", $info);
    echo $info;
}
?>
