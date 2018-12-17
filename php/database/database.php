<?php

namespace Database;

class Database{
  const HOST_DB="localhost";
  const USERNAME="root";
  const PASSWORD="root";
  const DB_NAME="museo-ferrari";
  
  private static $connection;
    
  public function __construct(){
    if(!Database::isConnected()){
        Database::$connection = new \mysqli(static::HOST_DB,static::USERNAME,static::PASSWORD,static::DB_NAME);
        Database::$connection->set_charset('utf8');
    }
    return Database::isConnected();
  }
    
  public static function disconnect(){
    if(Database::isConnected()) Database::$connection->close();
  }
  
  public static function isConnected(){
    if(isset(Database::$connection) && !Database::$connection->connect_errno)return true;
    return false;
  }
    
  private static function selectRows($query){
    if(Database::isConnected()){
        $result=Database::$connection->query($query);
        if($result->num_rows==0) return null;
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return null;
  }
    
  public static function selectEvents($type,$limit){
    $query="SELECT * FROM Evento WHERE Tipo=\"$type\" ORDER BY DataInizio LIMIT $limit;";
    return Database::selectRows($query);
  }
    
  public static function selectAutoModels($limit){
    $query="SELECT * FROM AutoEsposte LIMIT $limit;";
    return Database::selectRows($query);
  }
    
  public static function searchAutoModels($model,$limit){
    $query="SELECT * FROM AutoEsposte WHERE Modello LIKE '%\"$model\"% LIMIT $limit;";
    return Database::selectRows($query);
  }
    
  public static function selectCurrentEvent(){
    $currentEvent=Database::selectEvents("corrente",1);
    if(isset($currentEvent)) return $currentEvent[0];
    return null;
  }
    
  public static function newsletter($email){
    $query="SELECT Email FROM Utente WHERE Email = \"$email\";";
    $user=Database::selectRows($query);
    if(isset($user))return true;
    return false;
  }
  
}