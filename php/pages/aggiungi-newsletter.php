<?php
	include("../connection.php");
	
	if(isset($_POST['email'])){
		$email = $_POST['email'];
		$stmt = $conn->prepare"SELECT COUNT(*) AS nRighe FROM Utente WHERE Email = ".$email.";";
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		//print_r($result);
		$nRighe = $result['nRighe'];
		if($nRighe == 0){
			$stmt = $conn->prepare"INSERT INTO Utente (Email, NewsLetter) VALUES (".$email.", true);";
			$stmt->execute();
		}
		else{
			$stmt = $conn->prepare"SELECT ID FROM Utente WHERE Email = ".$email.";";
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$id = $result['ID'];
			$stmt = $conn->prepare"UPDATE Utente SET NewsLetter=true WHERE ID = ".$id.";";
			$stmt->execute();
		}
		header('http://localhost/info-e-contatti');
	}
	else{
		print_r("value è (non settato) ");
		print_r($value);
		header('http://localhost/info-e-contatti');
	}
?>
