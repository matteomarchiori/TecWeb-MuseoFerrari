<?php
	include("../connection.php");
	echo "
	<div id='content'>
	<div class='container'>
		<div class='col-4 col-xl-4'>
			<form id='formRicerca' method='post' action='/modelli-esposti?pagina=1'>
				<input id='inpTextRic' type='text' placeholder='Ricerca...' name='ric' tabindex='7'>
				<input type='submit' value=''>
			</form>
		</div>
	</div>";
	/*parte per la ricerca*/
	$ricerca=false;
    if(isset($_POST["ric"]))
    $value=$_POST["ric"];
	if(isset($value)){
		//print_r("value è ");
		//print_r($value);
		$ricerca=true;
		$where="Modello LIKE '%".$value."%";
		$stmt = $conn->prepare("SELECT COUNT(*) AS nRighe FROM AutoEsposte WHERE ".$where.";"); 
	}
	else{
		//print_r("value è (non settato) ");
		//print_r($value);
		$stmt = $conn->prepare("SELECT COUNT(*) AS nRighe FROM AutoEsposte WHERE 1"); 
	}
    $stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	//print_r($result);
	$nRighe=$result['nRighe'];
	$righeVisibili=10;
	$nPagine=ceil($nRighe/$righeVisibili);
	//print_r($nPagine);
	$pagina=$_GET['pagina'];
	$offset= ($pagina*$righeVisibili)-$righeVisibili;
	/*SELECT *
FROM autoesposte
WHERE Modello LIKE '%315%' OR Anno LIKE '%315%' OR TipoMotore LIKE '%315%' OR Cilindrata LIKE '%315%' OR PotenzaCv LIKE '%315%' OR VelocitaMax LIKE '%315%';*/
	if($ricerca==true){
		$stmt = $conn->prepare("SELECT * FROM AutoEsposte WHERE ".$where." LIMIT ".$righeVisibili." OFFSET ".$offset);
	}
	else{
		$stmt = $conn->prepare("SELECT * FROM AutoEsposte WHERE 1 LIMIT ".$righeVisibili." OFFSET ".$offset); 
	}
    $stmt->execute();
	
    // set the resulting array to associative
    while($result1 = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($result);
		// dubbio su id= eventoprincipale lo riciclo? che sia class? ma file diversi.
		echo "	<div class='container'>
					<div class='col-4 col-xl-2 infomodello'>
					<h1>".$result1['Modello']."</h1>	
					<table class='tablemodelli' summary='Specifiche modello ".$result1['Modello']."'>
						<tr>
							<th scope='row' abbr='anno'>Anno produzione</th>
							<td>".$result1['Anno']."</td>
						</tr>
						<tr>
							<th scope='row' abbr='stato cons'>Stato Conservazione</th>
							<td>".$result1['StatoConservazione']." su 10</td>
						</tr>
						<tr>
							<th scope='row' abbr='esp'>Esposta</th>
							<td>";
								if($result1['Esposta']==0) 
									echo"No"; 
								else 
									echo"Sì";
						echo "</td>
						</tr>
						<tr>
							<th scope='row' abbr='mot'>Motore</th>
							<td>".$result1['TipoMotore']."</td>
						</tr>
						<tr>
							<th scope='row' abbr='cil'>Cilindrata</th>
							<td>".$result1['Cilindrata']." cc</td>
						</tr>
						<tr>
							<th scope='row' abbr='cil'>Potenza</th>
							<td>".$result1['PotenzaCv']." cv</td>
						</tr>
						<tr>
							<th scope='row' abbr='vel max'>Velocita Massima</th>
							<td>".$result1['VelocitaMax']." km/h</td>
						</tr>
					</table>
					</div>
					<div class='col-4 col-xl-2 fotomodello'>
						
						<img src='".$result1['percorsoFoto']."' id='immagineprincipale' alt='Logo del Museo Ferrari' />
						
					</div>
				</div>
			";
	}
	echo"<div class='container'>";
					if($pagina>1){
						$pBack=$pagina-1;
					}else{
						$pBack=$pagina;
					}
					/*tabindex fino a 6 con l'header
					* 7 il find
					* ACCESSKEY MAP:
					* 8 INDIETRO -> (previous) n
					* 9 AVANTI -> (next) p
					*/
					echo "<div class='col-4 pulsantePag'><a href='/modelli-esposti?pagina=".$pBack."' tabindex='8' accesskey='p'><div id='back'><p>INDIETRO</p></div></a></div>"; 
					
					echo "<div class='col-4 pulsantePag'><div id='current'><p>".$pagina."</p></div></div>"; 
					
					if($pagina<$nPagine){
						$pNext=$pagina+1;
					}else{
						$pNext=$pagina;
					}
					echo "<div class='col-4 pulsantePag'><a href='/modelli-esposti?pagina=".$pNext."' tabindex='9' accesskey='n'><div id='next'><p>AVANTI</p></div></a></div>
		</div>
	</div>"; 
?>