<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
use Database\Database;
$database = new Database();
if($database){
    if(isset($_POST['email'])){
      $email = $_POST['email'];
      $stmt = $conn -> prepare("SELECT COUNT(*) AS nRighe FROM Utente WHERE Email = \"$email\";");
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $nRighe = $result['nRighe'];
      if($nRighe == 0){
        $stmt = $conn->prepare("INSERT INTO Utente (Email, NewsLetter) VALUES (\"$email\", true);");
        $stmt->execute();
      }
      else{
        $stmt = $conn->prepare("SELECT ID FROM Utente WHERE Email = \"$email\";");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $result['ID'];
        $stmt = $conn->prepare("UPDATE Utente SET NewsLetter=true WHERE ID = $id;");
        $stmt->execute();
      }
      $info = str_replace("SUBSCRIBE","<p>Grazie per esserti iscritto alla nostra newsletter.</p>",$info);
    }
    else $info = str_replace("SUBSCRIBE","",$info);
    echo $info;
}
?>
