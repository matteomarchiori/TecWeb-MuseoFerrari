<?php

namespace Database;

class Database {

    const HOST_DB = "localhost";
    const USERNAME = "root";
    const PASSWORD = "root";
    const DB_NAME = "museo-ferrari";

    private static $connection;

    public function __construct() {
        if (!Database::isConnected()) {
            Database::$connection = new \mysqli(static::HOST_DB, static::USERNAME, static::PASSWORD, static::DB_NAME);
            Database::$connection->set_charset('utf8');
        }
        return Database::isConnected();
    }

    public static function disconnect() {
        if (Database::isConnected())
            Database::$connection->close();
    }

    public static function isConnected() {
        if (isset(Database::$connection) && !Database::$connection->connect_errno)
            return true;
        return false;
    }

    private static function selectRows($query) {
        if (Database::isConnected()) {
            $result = Database::$connection->query($query);
            if ($result->num_rows == 0)
                return null;
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    private static function insertUpdateDelete($query) {
        if (Database::isConnected()) {
            Database::$connection->query($query);
            if (Database::$connection->affected_rows > 0)
                return true;
            return false;
        }
        return false;
    }

    public static function selectEvents($type, $limit) {
        $query = "SELECT * FROM Evento WHERE Tipo=\"$type\" ORDER BY DataInizio LIMIT $limit;";
        return Database::selectRows($query);
    }

    public static function selectAutoModels($model, $limit, $offset) {
        $query = "SELECT * FROM AutoEsposte WHERE Modello LIKE \"%$model%\" LIMIT $limit OFFSET $offset;";
        return Database::selectRows($query);
    }

    public static function selectCurrentEvent() {
        $currentEvent = Database::selectEvents("corrente", 1);
        if (isset($currentEvent)) return $currentEvent[0];
        return null;
    }

    public static function newsletter($email) {
        $query = "SELECT Email FROM Utente WHERE Email = \"$email\";";
        $user = Database::selectRows($query);
        if (isset($user))
            $query = "UPDATE Utente SET NewsLetter=true WHERE Email = \"$email\";";
        else
            $query = "INSERT INTO Utente (Email, NewsLetter) VALUES (\"$email\", true);";
        return Database::insertUpdateDelete($query);
    }
    
    public static function insertUser($nome,$cognome,$telefono,$email,$indirizzo,$citta,$stato,$cap,$newsletter) {
        $query = "INSERT INTO Utente (Nome, Cognome, Telefono, Email, Indirizzo, Citta, Stato, CAP, NewsLetter) VALUES (\"$nome\", \"$cognome\", \"$telefono\", \"$email\", \"$indirizzo\", \"$citta\", \"$stato\", \"$cap\", $newsletter);";
        return Database::insertUpdateDelete($query);
    }
    
    public static function buyTickets($utente,$evento,$data,$biglietti) {
        $query = "INSERT INTO Biglietti (Utente, Evento, Data, NrBiglietti) VALUES ($utente, $evento, \"$data\", $biglietti);";
        return Database::insertUpdateDelete($query);
    }
}
