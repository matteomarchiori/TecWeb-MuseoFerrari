<?php

namespace Database;

class Database {

    const HOST_DB = "localhost";
    const USERNAME = "gperon";
    const PASSWORD = "ohjo3aiXohthooT2";
    const DB_NAME = "gperon";

    private static $connection;

    public function __construct() {
        if (!self::isConnected()) {
            self::$connection = new \mysqli(static::HOST_DB, static::USERNAME, static::PASSWORD, static::DB_NAME);
            self::$connection->set_charset('utf8');
        }
        return self::isConnected();
    }

    public static function disconnect() {
        if (self::isConnected())
            self::$connection->close();
    }

    public static function isConnected() {
        if (isset(self::$connection) && !self::$connection->connect_errno)
            return true;
        return false;
    }

    private static function selectRows($query) {
        if (self::isConnected()) {
            $result = self::$connection->query($query);
            if ($result->num_rows == 0)
                return null;
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    private static function insertUpdateDelete($query) {
        if (self::isConnected()) {
            self::$connection->query($query);
            if (self::$connection->affected_rows > 0)
                return true;
            return false;
        }
        return false;
    }

    public static function selectEvents($type, $limit) {
        $type = self::$connection->real_escape_string($type);
        if(!is_int($limit)) return null;
        $query = "SELECT * FROM Evento WHERE Tipo=\"$type\" ORDER BY DataInizio LIMIT $limit;";
        return self::selectRows($query);
    }

    public static function selectAutoModels($model, $limit, $offset) {
        $model = self::$connection->real_escape_string($model);
        if(!is_int($limit)) return null;
        if(!is_int($offset)) return null;
        $query = "SELECT * FROM AutoEsposte WHERE Modello LIKE \"%$model%\" LIMIT $limit OFFSET $offset;";
        return self::selectRows($query);
    }
    
    public static function selectNumberAutoModels($model) {
        $model = self::$connection->real_escape_string($model);
        $query = "SELECT COUNT(*) as count FROM AutoEsposte WHERE Modello LIKE \"%$model%\";";
        return self::selectRows($query)[0]['count'];
    }

    public static function selectCurrentEvent() {
        $currentEvent = self::selectEvents("corrente", 1);
        if (isset($currentEvent))
            return $currentEvent[0];
        return null;
    }
    
	public static function selectEventById($id) {
		if(!is_numeric($id)) return null;
        $query = "SELECT * FROM Evento WHERE ID=$id LIMIT 1;";
        $rows = self::selectRows($query);
        if(isset($rows))
            return $rows[0];
        return null;
    }
    
	public static function selectEventsLessOne($id) {
        if(!is_numeric($id)) return null;
        $query = "SELECT * FROM Evento WHERE ID!=$id ORDER BY DataInizio LIMIT 3;";
        return self::selectRows($query);
    }
    
    public static function selectUser($email) {
        $email = self::$connection->real_escape_string($email);
        $query = "SELECT ID FROM Utente WHERE Email = \"$email\";";
        $users = self::selectRows($query);
        if (isset($users))
            return $users[0];
        return null;
    }

    public static function newsletter($email) {
        $email = self::$connection->real_escape_string($email);
        $query = "SELECT Email FROM Utente WHERE Email = \"$email\";";
        $user = self::selectRows($query);
        if (isset($user))
            $query = "UPDATE Utente SET NewsLetter=true WHERE Email = \"$email\";";
        else
            $query = "INSERT INTO Utente (Email, NewsLetter) VALUES (\"$email\", true);";
        return self::insertUpdateDelete($query);
    }

    public static function registerUser($nome, $cognome, $datanascita, $comunenascita, $telefono, $email, $stato, $indirizzo, $citta, $newsletter) {
        $nome = self::$connection->real_escape_string($nome);
        $cognome = self::$connection->real_escape_string($cognome);
        $datanascita = self::$connection->real_escape_string($datanascita);
        $comunenascita = self::$connection->real_escape_string($comunenascita);
        $email = self::$connection->real_escape_string($email);
        $stato = self::$connection->real_escape_string($stato);
        $indirizzo = self::$connection->real_escape_string($indirizzo);
        $citta = self::$connection->real_escape_string($citta);
        $newsletter = is_bool($newsletter);
        if($newsletter) $newsletter = "true";
        else $newsletter = "false";
        if(!is_numeric($telefono)) return null;
        $query = "INSERT INTO Utente (Nome, Cognome, DataNascita, ComuneNascita, Telefono, Email, Indirizzo, Citta, Stato, NewsLetter) VALUES (\"$nome\", \"$cognome\", \"$datanascita\", \"$comunenascita\", \"$telefono\", \"$email\", \"$indirizzo\", \"$citta\", \"$stato\", $newsletter);";
        return self::insertUpdateDelete($query);
    }

    public static function buyTickets($utente, $evento, $data, $biglietti) {
        
        if(!is_numeric($utente) || !is_numeric($evento) || !is_numeric($biglietti)) return null;
        
        $data = self::$connection->real_escape_string($data);
        
        $query = "INSERT INTO Biglietti (Utente, Evento, Data, NrBiglietti) VALUES ($utente, $evento, \"$data\", $biglietti);";
        return self::insertUpdateDelete($query);
    }

}
