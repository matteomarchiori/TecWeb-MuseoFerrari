<?php
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";
    use Database\Database;
    $database = new Database();
    if($database){
        $modelli = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "modelli-esposti.html");
        $righeVisibili=10;
        if(isset($_POST["ric"])){
            $search = $_POST['ric'];
        }
        else
            $search="";
        if(isset($_GET['pagina']))
            $pagina=$_GET['pagina'];
        else 
            $pagina=1;
        $offset=($pagina*$righeVisibili)-$righeVisibili;
        $automobili = Database::selectAutoModels($search,$righeVisibili,$offset);
        if(isset($automobili)){
            $modelliPagina="";
            $nRighe=count($automobili);
            $nPagine=ceil($nRighe/$righeVisibili);
            $fileModello = file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "modello-esposto.html");
            for($auto=0;$auto<$nRighe;$auto++){
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
            if($pagina>1) 
                $modelli = str_replace("*paginaback*","<div id='back'><a href='./modelli-esposti?pagina=".($pagina-1)."' tabindex='8' accesskey='p'>INDIETRO</a></div>",$modelli);
            else 
                $modelli = str_replace("*paginaback*","",$modelli);
            $modelli = str_replace("*paginacorrente*","<div id='current'><p>$pagina</p></div>",$modelli);
            if($pagina<=$nPagine) 
                $modelli = str_replace("*paginanext*","<div id='next'><a href='./modelli-esposti?pagina=".($pagina+1)."' tabindex='9' accesskey='n'>AVANTI</a></div>",$modelli);
            else 
                $modelli = str_replace("*paginanext*","",$modelli);
            $modelli = str_replace("*nessunrisultato*","",$modelli);
            $modelli = str_replace("*error*","",$modelli);
            echo $modelli;
        }
        else{
            $modelli = str_replace("*modelliesposti*","",$modelli);
            $modelli = str_replace("*error*","",$modelli);
            $modelli = str_replace("*paginaback*","",$modelli);
            $modelli = str_replace("*paginacorrente*","",$modelli);
            $modelli = str_replace("*paginanext*","",$modelli);
            $modelli = str_replace("*nessunrisultato*",'<p class="error">Nessun modello corrispondente alla ricerca: "'.$search.'"</p><a href="./modelli-esposti?pagina=1">Torna alla pagina modelli esposti</a>',$modelli);
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

