<?php
	include("../connection.php");
	$email = $_POST['email'];
	$stmt = $conn->prepare"SELECT COUNT(*) AS nRighe FROM utente WHERE Email = '".$email."'";
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$nRighe=$result['nRighe'];
	if($nRighe==0){
		$stmt = $conn->prepare"INSERT INTO utente (Email, NewsLetter) VALUES ('".$email."', 'true')";
		$stmt->execute();
	}
	else{
		$stmt = $conn->prepare"SELECT ID FROM utente WHERE Email = '".$email."'";
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$id=$result['ID'];
		$stmt = $conn->prepare"UPDATE SET NewsLetter=true WHERE ID = '".$id."'";
		$stmt->execute();
	}
?>