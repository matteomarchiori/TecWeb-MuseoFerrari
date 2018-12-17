<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
use Database\Database;
$database = new Database();
if($database){
    $info = file_get_contents("../../html/pages/info-e-contatti.html");
    if(isset($_POST['email'])){
      $email = $_POST['email'];
      $newsletter = Database::newsletter($email);
      if($newsletter) $info = str_replace("SUBSCRIBE","<p>Grazie per esserti iscritto alla nostra newsletter.</p>",$info);
      else $info = str_replace("SUBSCRIBE","<p>L'iscrizione non e' andata a buon fine. Contattaci tramite l'apposito form.</p>",$info);
    }
    else $info = str_replace("SUBSCRIBE","",$info);
    echo $info;
}
?>
