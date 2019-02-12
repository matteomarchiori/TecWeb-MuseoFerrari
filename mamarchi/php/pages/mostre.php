<?php
	require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
	use Database\Database;
    
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "common" . DIRECTORY_SEPARATOR . "utilities.php";
    use Utilities\Utilities;
    
	$database = new Database();
	if($database){
		$mostre = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "mostre.html");
	}
	if(!isset($_GET['event'])){
		$id=Database::selectCurrentEvent();
		$idMostraVisibile=$id['ID'];
	}
	else{
		$idMostraVisibile=$_GET['event'];
	}
	$eventoCorrente = Database::selectEventById($idMostraVisibile);
	if(isset($eventoCorrente)){
		$mostre = str_replace("*titolocorrente*",$eventoCorrente['Titolo'],$mostre);
		$mostre = str_replace("*stato*",getStato($eventoCorrente['Tipo']), $mostre);//se torna null resta bianco
		$mostre = str_replace("*datainiziocorrente*",date("d/m/Y", strtotime($eventoCorrente['DataInizio'])),$mostre);
		$mostre = str_replace("*datafinecorrente*",date("d/m/Y", strtotime($eventoCorrente['DataFine'])),$mostre);
		$mostre = str_replace("*testoprincipale*",$eventoCorrente['LungaDescrizione'],$mostre);
		$mostre = str_replace("*fotoprincipale*",$eventoCorrente['percorsoFoto1'],$mostre);
		$mostre = str_replace("*altfotoprincipale*",$eventoCorrente['altFoto1'],$mostre);
	}
	$altriEventi=Database::selectEventsLessOne($idMostraVisibile);
	//print_r($altriEventi);
	
    if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
	$mostre = str_replace("*linkmostra1*","<a tabindex='$tabIndex' href='./mostre?event=".$altriEventi[0]['ID']."'>".$altriEventi[0]['Titolo']."</a>", $mostre,$counter);
	$mostre = str_replace("*stato1*",getStato($altriEventi[0]['Tipo']), $mostre);//se torna null resta bianco
	$mostre = str_replace("*datainiziomostra1*",date("d/m/Y", strtotime($altriEventi[0]['DataInizio'])), $mostre);
	$mostre = str_replace("*datafinemostra1*",date("d/m/Y", strtotime($altriEventi[0]['DataFine'])), $mostre);
    if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
	$mostre = str_replace("*linkmostra2*","<a tabindex='$tabIndex' href='./mostre?event=".$altriEventi[1]['ID']."'>".$altriEventi[1]['Titolo']."</a>", $mostre, $counter);
	$mostre = str_replace("*stato2*",getStato($altriEventi[1]['Tipo']), $mostre);//se torna null resta bianco
	$mostre = str_replace("*datainiziomostra2*",date("d/m/Y", strtotime($altriEventi[1]['DataInizio'])), $mostre);
	$mostre = str_replace("*datafinemostra2*",date("d/m/Y", strtotime($altriEventi[1]['DataFine'])), $mostre);
    if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
	$mostre = str_replace("*linkmostra3*","<a tabindex='$tabIndex' href='./mostre?event=".$altriEventi[2]['ID']."'>".$altriEventi[2]['Titolo']."</a>", $mostre,$counter);
	$mostre = str_replace("*stato3*",getStato($altriEventi[2]['Tipo']), $mostre);//se torna null resta bianco
	$mostre = str_replace("*datainiziomostra3*",date("d/m/Y", strtotime($altriEventi[2]['DataInizio'])), $mostre);
	$mostre = str_replace("*datafinemostra3*",date("d/m/Y", strtotime($altriEventi[2]['DataFine'])), $mostre);
	echo $mostre;
	
	function getStato($tipo){
		switch($tipo){
			case "futuro": return "IN PROGRAMMA";
			case "corrente": return "IN CORSO";
			default: return null;
		}
	}
?>