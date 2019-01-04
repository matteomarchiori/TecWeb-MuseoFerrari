<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
use Database\Database;
$database = new Database();
if($database){
  $home = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "home.html");
  $eventoCorrente = Database::selectCurrentEvent();
  if(isset($eventoCorrente)){
    $home = str_replace("TITOLOCORRENTE",$eventoCorrente['Titolo'],$home);
    $home = str_replace("DATAINIZIOCORRENTE",date("d/m/Y", strtotime($eventoCorrente['DataInizio'])),$home);
    $home = str_replace("DATAFINECORRENTE",date("d/m/Y", strtotime($eventoCorrente['DataFine'])),$home);
    $home = str_replace("TESTOPRINCIPALE",$eventoCorrente['LungaDescrizione'],$home);
    $home = str_replace("FOTOPRINCIPALE",$eventoCorrente['percorsoFoto1'],$home);
    $home = str_replace("ALTFOTOPRINCIPALE",$eventoCorrente['altFoto1'],$home);
  }
  $eventiFuturi = Database::selectEvents("futuro",3);
  if(isset($eventiFuturi)){
    foreach($eventiFuturi as $key=>$evento){
      $home = str_replace("TITOLOEVENTO".$key,$evento['Titolo'],$home);
      $home = str_replace("INIZIOEVENTO".$key,date("d/m/Y", strtotime($evento['DataInizio'])),$home);
      $home = str_replace("FINEEVENTO".$key,date("d/m/Y", strtotime($evento['DataFine'])),$home);
      $home = str_replace("DESCRIZIONEEVENTO".$key,$evento['BreveDescrizione'],$home);
      $home = str_replace("FOTOEVENTO".$key,$evento['percorsoFoto1'],$home);
      $home = str_replace("ALTFOTOEVENTO".$key,$evento['altFoto1'],$home);
    }
  }
  echo $home;
}