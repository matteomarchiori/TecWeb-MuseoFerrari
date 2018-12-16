<?php

namespace Database;

class Database{
  const HOST_DB="localhost";
  const USERNAME="root";
  const PASSWORD="root";
  const DB_NAME="museo-ferrari";
  
  private static $connection;
    
  public static function connect(){
    if(!Database::isConnected()) Database::$connection = new \mysqli(static::HOST_DB,static::USERNAME,static::PASSWORD,static::DB_NAME);
    return Database::isConnected();
  }
    
  public static function disconnect(){
    if(Database::isConnected()) Database::$connection->close();
  }
  
  public static function isConnected(){
    if(isset(Database::$connection) && !Database::$connection->connect_errno)return true;
    return false;
  }
    
  public static function selectEvents($type,$limit){
    $query="SELECT * FROM Evento WHERE Tipo=\"$type\" ORDER BY DataInizio LIMIT $limit;";
    if(Database::isConnected()){
        $result=Database::$connection->query($query);
        if($result->num_rows==0) return null;
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return null;
  }
    
  public static function selectCurrentEvent(){
    $currentEvent=Database::selectEvents("corrente",1);
    if(isset($currentEvent)){
      return $currentEvent[0];
    }
    return null;
  }
  
}