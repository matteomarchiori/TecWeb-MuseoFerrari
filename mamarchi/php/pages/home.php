<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
use Database\Database;
$database = new Database();
if($database){
  $home = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "home.html");
  $eventoCorrente = Database::selectCurrentEvent();
  if(isset($eventoCorrente)){
    $home = str_replace("*titolocorrente*",$eventoCorrente['Titolo'],$home);
    $home = str_replace("*datainiziocorrente*",date("d/m/Y", strtotime($eventoCorrente['DataInizio'])),$home);
    $home = str_replace("*datafinecorrente*",date("d/m/Y", strtotime($eventoCorrente['DataFine'])),$home);
    $home = str_replace("*testoprincipale*",$eventoCorrente['LungaDescrizione'],$home);
    $home = str_replace("*fotoprincipale*",$eventoCorrente['percorsoFoto1'],$home);
    $home = str_replace("*altfotoprincipale*",$eventoCorrente['altFoto1'],$home);
  }
  $eventiFuturi = Database::selectEvents("futuro",3);
  if(isset($eventiFuturi)){
    foreach($eventiFuturi as $key=>$evento){
      $home = str_replace("*titoloevento".$key."*",$evento['Titolo'],$home);
      $home = str_replace("*inizioevento".$key."*",date("d/m/Y", strtotime($evento['DataInizio'])),$home);
      $home = str_replace("*fineevento".$key."*",date("d/m/Y", strtotime($evento['DataFine'])),$home);
      $home = str_replace("*descrizioneevento".$key."*",$evento['BreveDescrizione'],$home);
      $home = str_replace("*fotoevento".$key."*",$evento['percorsoFoto1'],$home);
      $home = str_replace("*altfotoevento".$key."*",$evento['altFoto1'],$home);
    }
  }
  echo $home;
}