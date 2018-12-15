<?php
	echo"
		<div id='content'>
			<div class='container'>
				<div class='infoEContatti ColonnaInfoEContatti'>
					<h1>Vuoi rimanere aggiornato sulle nostre mostre?</h1>
					<p>Iscriviti alla nostra newsletter</p>
					</br>
					<form action='/info-e-contatti' method='post'>
						Email: <input type='text' name='email' id='email'/>
						<input type='submit' value='Invia'>
					</form>";
			include("../connection.php");
	
			if(isset($_POST['email'])){
				$email = $_POST['email'];
				$stmt = $conn -> prepare("SELECT COUNT(*) AS nRighe FROM Utente WHERE Email = ".$email.";");
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				//print_r($result);
				$nRighe = $result['nRighe'];
				if($nRighe == 0){
					$stmt = $conn->prepare("INSERT INTO Utente (Email, NewsLetter) VALUES (".$email.", true);");
					$stmt->execute();
					echo"<p>Sei stato aggiunto alla nostra Newsletter</p>";
				}
				else{
					$stmt = $conn->prepare("SELECT ID FROM Utente WHERE Email = ".$email.";");
					$stmt->execute();
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					$id = $result['ID'];
					$stmt = $conn->prepare("UPDATE Utente SET NewsLetter=true WHERE ID = ".$id.";");
					$stmt->execute();
					echo"<p>Sei stato aggiunto alla nostra Newsletter</p>";
				}
			}
			echo"
				</div>
				<div class='infoEContatti ColonnaInfoEContatti'>
					<h1>Come raggiungerci</h1>
					<p>Ci troviamo a pochi passi dalla zona di Padova Fiere ed è facilmete raggiungibile.</p>
					<h3>Con i mezzi pubblici</h3>
					<p>Autobus: 101, 10</p>
					<h3>In bici</h3>
					<p>Stazione GoodBike davanti Palazzo di Giustizia di Padova</p>
					<h3>Dalla stazione dei treni</h3>
					<p>Facendo una piacevole passeggiata di un chilometro</p>
				</div>
				<div class='infoEContatti ColonnaInfoEContatti'>
					<h1>Come contattarci</h1>
					<h3>Email</h3>
					<p>museo.ferrari@info.it</p>
					<h3>Tel e Fax</h3>
					<p>0499221289</p>
				</div>

			</div>
			<div class='container'>
			<div class='col-4 col-xl-4'>
			<iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2800.8988785983406!2d11.885278551102601!3d45.41137867899782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!	1s0x477eda58b44676df%3A0xfacae5884fca17f5!2sTorre+Archimede%2C+Via+Trieste%2C+63%2C+35121+Padova+PD!5e0!3m2!1sit!2sit!4v1543861626279\' id='maps'>
			</iframe>
			</div>
			</div>
		</div>";
?>
