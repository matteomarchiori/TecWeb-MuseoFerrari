<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "database.php";

use Database\Database;

$database = new Database();
if ($database) {
    if(isset($_GET['id'])){
        $event = Database::selectEventById($_GET['id']);
        echo json_encode($event);
    }
}