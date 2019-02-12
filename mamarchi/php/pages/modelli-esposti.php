<?php
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
    use Database\Database;
    
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "common" . DIRECTORY_SEPARATOR . "utilities.php";
    use Utilities\Utilities;
    
    $database = new Database();
    if($database){
        $modelli = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "modelli-esposti.html");
        $righeVisibili=10;
        if(isset($_POST["ric"])){
            $search = $_POST['ric'];
        }
        else{
            $search="";
        }
        if(isset($_GET['pagina']))
            $pagina=$_GET['pagina'];
        else 
            $pagina=1;
        $offset=($pagina*$righeVisibili)-$righeVisibili;
        $nAutomobili = Database::selectNumberAutoModels($search);
        if(isset($nAutomobili) && $nAutomobili>0){
            $modelli = str_replace("*opencontainer*","<div class='container'>",$modelli);
            $modelli = str_replace("*closecontainer*","</div>",$modelli);
            $modelliPagina="";
            $nPagine=ceil($nAutomobili/$righeVisibili);
            $automobili = Database::selectAutoModels($search,$righeVisibili,$offset);
            $fileModello = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "modello-esposto.html");
            for($auto=0;$auto<count($automobili);$auto++){
                $modello = $fileModello;
                $modello = str_replace("*modello*",$automobili[$auto]['Modello'],$modello);
                $modello = str_replace("*annoproduzione*",$automobili[$auto]['Anno'],$modello);
                $modello = str_replace("*statoconservazione*",$automobili[$auto]['StatoConservazione'],$modello);
                if($automobili[$auto]['Esposta'])
                    $esposta="Sì";
                else 
                    $esposta = "No";
                $modello = str_replace("*esposta*",$esposta,$modello);
                $modello = str_replace("*tipomotore*",$automobili[$auto]['TipoMotore'],$modello);
                $modello = str_replace("*cilindrata*",$automobili[$auto]['Cilindrata'],$modello);
                $modello = str_replace("*potenzacv*",$automobili[$auto]['PotenzaCv'],$modello);
                $modello = str_replace("*velocitamax*",$automobili[$auto]['VelocitaMax'],$modello);
                $modello = str_replace("*percorsofoto*",$automobili[$auto]['percorsoFoto'],$modello);
                $modello = str_replace("*altfoto*",$automobili[$auto]['Modello'],$modello);
                $modelliPagina.=$modello;
            }
            $modelli = str_replace("*modelliesposti*",$modelliPagina,$modelli);
            if($pagina>1){
                if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
                $modelli = str_replace("*paginaback*","<div class='pulsantePag' id='pulsanteBack'><div id='back'><a href='./modelli-esposti?pagina=".($pagina-1)."' tabindex='$tabIndex'>INDIETRO</a></div></div>",$modelli,$counter);
            }
            $modelli = str_replace("*paginacorrente*","<div class='pulsantePag' id='numPagina'><div id='current'><p>$pagina</p></div></div>",$modelli);
            if($pagina<$nPagine){
                if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
                $modelli = str_replace("*paginanext*","<div class='pulsantePag' id='pulsanteNext'><div id='next'><a href='./modelli-esposti?pagina=".($pagina+1)."' tabindex='$tabIndex'>AVANTI</a></div></div>",$modelli,$counter);
            }
            $modelli = str_replace("*nessunrisultato*","",$modelli);
            $modelli = str_replace("*error*","",$modelli);
        }
        else{
            $modelli = str_replace("*nessunrisultato*",'<p class="error">Nessun modello corrispondente alla ricerca: "'.$search.'"</p><a href="./modelli-esposti">Torna ai modelli esposti</a>',$modelli);
        }
        $modelli = str_replace("*opencontainer*","",$modelli);
        $modelli = str_replace("*closecontainer*","",$modelli);
        $modelli = str_replace("*paginaback*","",$modelli);
        $modelli = str_replace("*paginanext*","",$modelli);
        $modelli = str_replace("*modelliesposti*","",$modelli);
        $modelli = str_replace("*error*","",$modelli);
        $modelli = str_replace("*paginaback*","",$modelli);
        $modelli = str_replace("*paginacorrente*","",$modelli);
        $modelli = str_replace("*paginanext*","",$modelli);
        if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
        $modelli = str_replace("*tabindextestocerca*",$tabIndex,$modelli,$counter);
        if ($counter > 0) Utilities::checkCounter($counter,$tabIndex);
        $modelli = str_replace("*tabindexcerca*",$tabIndex,$modelli,$counter);
        echo $modelli;
    }