<?php
	include("../connection.php");
	$stmt = $conn->prepare	(	"SELECT * , 
								DAY(DataInizio) as gDataInizio, DAY(DataFine) as gDataFine, 
								MONTH(DataInizio) as mDataInizio, MONTH(DataFine) as mDataFine, 
								YEAR(DataInizio) as aDataInizio, YEAR(DataFine) as aDataFine 
								FROM Evento WHERE Tipo='corrente'"
							); 
    $stmt->execute();
	$eventoCorrente  = $stmt->fetch(PDO::FETCH_ASSOC);
	$arrayDataInizio = array($eventoCorrente ['gDataInizio'],$eventoCorrente ['mDataInizio'],$eventoCorrente ['aDataInizio']);
	$arrayDataFine = array($eventoCorrente ['gDataFine'],$eventoCorrente ['mDataFine'],$eventoCorrente ['aDataFine']);
	echo "
		<div id='content' class='container'>
			<div id='eventoprincipale' class='col-4 col-xl-2'>
				<h1>".$eventoCorrente['Titolo']."</h1>
				<h2> Dal ".$arrayDataInizio[0]." ".toMese($arrayDataInizio[1])." ".$arrayDataInizio[2]."
				al ".$arrayDataFine[0]." ".toMese($arrayDataFine[1])." ".$arrayDataFine[2]."</h2>
				<p id='testoprincipale'>".$eventoCorrente['LungaDescrizione']."</p>
			</div>
			<div id='slideshow' class='col-4 col-xl-2'>
				<img src='".$eventoCorrente['percorsoFoto1']."' id='immagineprincipale' alt='Logo del Museo Ferrari' />
			</div>

			<div id='presentazionegenerale' class='col-4 col-xl-4'>
				<h1>Il museo</h1>
				<p id='testone'>
				Il Museo Ferrari permette di vivere in prima persona il sogno del Cavallino Rampante: 
				un viaggio unico e coinvolgente attraverso le vetture che hanno fatto la storia 
				dell’automobilismo sulle piste e sulle strade di tutto il mondo. 
				Il Museo Ferrari permette di vivere in prima persona il sogno del Cavallino Rampante: 
				un viaggio unico e coinvolgente attraverso le vetture che hanno fatto la storia 
				dell’automobilismo sulle piste e sulle strade di tutto il mondo.
				Il Museo Ferrari permette di vivere in prima persona il sogno del Cavallino Rampante: 
				un viaggio unico e coinvolgente attraverso le vetture che hanno fatto la storia 
				dell’automobilismo sulle piste e sulle strade di tutto il mondo.<br>
				Il Museo Ferrari permette di vivere in prima persona il sogno del Cavallino Rampante: 
				un viaggio unico e coinvolgente attraverso le vetture che hanno fatto la storia 
				dell’automobilismo sulle piste e sulle strade di tutto il mondo.
				</p>
			</div>
			
			<div id='eventiprossimi' class='container'>
				<div class='col-4 col-xl-4'>
					<h1>Prossimamente in programma</h1>
				</div>
	";
	$stmt = $conn->prepare	(	"SELECT *,
								DAY(DataInizio) as gDataInizio, DAY(DataFine) as gDataFine, 
								MONTH(DataInizio) as mDataInizio, MONTH(DataFine) as mDataFine, 
								YEAR(DataInizio) as aDataInizio, YEAR(DataFine) as aDataFine 
								FROM Evento WHERE Tipo='futuro' ORDER BY DataInizio LIMIT 3"
							); 
    $stmt->execute();
	while($eventiFuturi = $stmt->fetch(PDO::FETCH_ASSOC)){
		$arrayDataInizio = array($eventiFuturi['gDataInizio'], $eventiFuturi['mDataInizio'], $eventiFuturi['aDataInizio']);
		$arrayDataFine = array($eventiFuturi['gDataFine'], $eventiFuturi['mDataFine'], $eventiFuturi['aDataFine']);
		$DataInizio = $eventiFuturi['gDataInizio']."/".$eventiFuturi['mDataInizio']."/".$eventiFuturi['aDataInizio'];
		$DataFine = $eventiFuturi['gDataFine']."/".$eventiFuturi['mDataFine']."/".$eventiFuturi['aDataFine'];
		date("d/m/Y", strtotime($eventiFuturi['DataInizio']));
		echo"
				<div class='treColonne'>
					<h1>".$eventiFuturi['Titolo']."</h1>
					<h2>
					Dal ".date("d/m/Y", strtotime($eventiFuturi['DataInizio']))."
					 al ".date("d/m/Y", strtotime($eventiFuturi['DataFine']))."
					</h2>
					<img src='".$eventiFuturi['percorsoFoto1']."' alt='".$eventiFuturi['altFoto1']."' />
					<p>".$eventiFuturi['BreveDescrizione']."</p>
				</div>
		";
	}
	echo "
			</div>
		</div>
	";
	function toMese($mese){
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
	}
?>