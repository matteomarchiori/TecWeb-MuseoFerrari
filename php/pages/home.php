<?php
	require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
    use Database\Database;
    $database = Database::connect();
    if($database){
      $home = file_get_contents("../../html/pages/home.html");
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
          $home = str_replace("DESCRIZIONEEVENTO".$key,$evento['LungaDescrizione'],$home);
          $home = str_replace("FOTOEVENTO".$key,$evento['percorsoFoto1'],$home);
          $home = str_replace("ALTFOTOEVENTO".$key,$evento['altFoto1'],$home);
        }
      }
      echo $home;
    }


	/*function toMese($mese){
		switch($mese){
		case 1:
			return "Gennaio";break;
		case 2:
			return "Febbraio";break;
		case 3:
			return "Marzo";break;
		case 4:
			return "Aprile";break;
		case 5:
			return "Maggio";break;
		case 6:
			return "Giugno";break;
		case 7:
			return "Luglio";break;
		case 8:
			return "Agosto";break;
		case 9:
			return "Settembre";break;
		case 10:
			return "Ottobre";break;
		case 11:
			return "Novembre";break;
		case 12:
			return "Dicembre";break;
		default:
			return null;break;
		}
	}*/