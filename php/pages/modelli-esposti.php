<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
use Database\Database;
$database = new Database();
if($database){
    $modelli = file_get_contents("../../html/pages/modelli-esposti.html");
    $righeVisibili=10;
    if(isset($_POST["ric"])) $search = $_POST['ric'];
    else $search="";
    if(isset($_GET['pagina']))$pagina=$_GET['pagina'];
    else $pagina=1;
    $offset=($pagina*$righeVisibili)-$righeVisibili;
    $automobili = Database::selectAutoModels($search,$righeVisibili,$offset);
    
    if(isset($automobili)){
      $modelliPagina="";
      $nRighe=count($automobili);
	  $nPagine=ceil($nRighe/$righeVisibili);
      $fileModello = file_get_contents("../../html/pages/modello-esposto.html");
      for($auto=0;$auto<$nRighe;$auto++){
        $modello = $fileModello;
        $modello = str_replace("MODELLO",$automobili[$auto]['Modello'],$modello);
        $modello = str_replace("ANNOPRODUZIONE",$automobili[$auto]['Anno'],$modello);
        $modello = str_replace("STATOCONSERVAZIONE",$automobili[$auto]['StatoConservazione'],$modello);
        if($automobili[$auto]['Esposta'])$esposta="Sì";
        else $esposta = "No";
        $modello = str_replace("ESPOSTA",$esposta,$modello);
        $modello = str_replace("TIPOMOTORE",$automobili[$auto]['TipoMotore'],$modello);
        $modello = str_replace("CILINDRATA",$automobili[$auto]['Cilindrata'],$modello);
        $modello = str_replace("POTENZACV",$automobili[$auto]['PotenzaCv'],$modello);
        $modello = str_replace("VELOCITAMAX",$automobili[$auto]['VelocitaMax'],$modello);
        $modello = str_replace("PERCORSOFOTO",$automobili[$auto]['percorsoFoto'],$modello);
        $modelliPagina.=$modello;
      }
      $modelli = str_replace("MODELLIESPOSTI",$modelliPagina,$modelli);
      if($pagina>1) $modelli = str_replace("PAGINABACK","<a href='/modelli-esposti?pagina=".($pagina-1)."' tabindex='8' accesskey='p'><div id='back'><p>INDIETRO</p></div></a>",$modelli);
      else $modelli = str_replace("PAGINABACK","",$modelli);
      $modelli = str_replace("PAGINACORRENTE",$pagina,$modelli);
      if($pagina<=$nPagine) $modelli = str_replace("PAGINANEXT","<a href='/modelli-esposti?pagina=".($pagina+1)."' tabindex='9' accesskey='n'><div id='next'><p>AVANTI</p></div></a>",$modelli);
      else $modelli = str_replace("PAGINANEXT","",$modelli);
      echo $modelli;
    }
}
		// dubbio su id= eventoprincipale lo riciclo? che sia class? ma file diversi.
		
    /*tabindex fino a 6 con l'header
    * 7 il find
    * ACCESSKEY MAP:
    * 8 INDIETRO -> (previous) n
    * 9 AVANTI -> (next) p
    */

