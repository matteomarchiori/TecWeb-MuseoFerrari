<?php

namespace Database;

class Database {

    const HOST_DB = "localhost";
    const USERNAME = "matteo";
    const PASSWORD = "password1324354";
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
        $type = Database::$connection->real_escape_string($type);
        if(!is_int($limit)) return null;
        $query = "SELECT * FROM Evento WHERE Tipo=\"$type\" ORDER BY DataInizio LIMIT $limit;";
        return Database::selectRows($query);
    }

    public static function selectAutoModels($model, $limit, $offset) {
        $model = Database::$connection->real_escape_string($model);
        if(!is_int($limit)) return null;
        if(!is_int($offset)) return null;
        $query = "SELECT * FROM AutoEsposte WHERE Modello LIKE \"%$model%\" LIMIT $limit OFFSET $offset;";
        return Database::selectRows($query);
    }

    public static function selectCurrentEvent() {
        $currentEvent = Database::selectEvents("corrente", 1);
        if (isset($currentEvent) && $currentEvent)
            return $currentEvent[0];
        return null;
    }
    
	public static function selectEventById($id) {
		if(!is_numeric($id)) return null;
        $query = "SELECT * FROM Evento WHERE ID=$id LIMIT 1;";
        $rows= Database::selectRows($query);
		return $rows[0];
    }
    
	public static function selectEventsLessOne($id) {
        if(!is_numeric($id)) return null;
        $query = "SELECT * FROM Evento WHERE ID!=$id ORDER BY DataInizio LIMIT 3;";
        return Database::selectRows($query);
    }
    
    public static function selectUser($email) {
        $email = Database::$connection->real_escape_string($email);
        $query = "SELECT ID FROM Utente WHERE Email = \"$email\";";
        $users = Database::selectRows($query);
        if (isset($users) && $users)
            return $users[0];
        return null;
    }

    public static function newsletter($email) {
        $email = Database::$connection->real_escape_string($email);
        $query = "SELECT Email FROM Utente WHERE Email = \"$email\";";
        $user = Database::selectRows($query);
        if (isset($user))
            $query = "UPDATE Utente SET NewsLetter=true WHERE Email = \"$email\";";
        else
            $query = "INSERT INTO Utente (Email, NewsLetter) VALUES (\"$email\", true);";
        return Database::insertUpdateDelete($query);
    }

    public static function registerUser($nome, $cognome, $datanascita, $comunenascita, $telefono, $email, $stato, $indirizzo, $citta, $newsletter) {
        $nome = Database::$connection->real_escape_string($nome);
        $cognome = Database::$connection->real_escape_string($cognome);
        $datanascita = Database::$connection->real_escape_string($datanascita);
        $comunenascita = Database::$connection->real_escape_string($comunenascita);
        $email = Database::$connection->real_escape_string($email);
        $stato = Database::$connection->real_escape_string($stato);
        $indirizzo = Database::$connection->real_escape_string($indirizzo);
        $citta = Database::$connection->real_escape_string($citta);
        $newsletter = is_bool($newsletter);
        if($newsletter) $newsletter = "true";
        else $newsletter = "false";
        if(!is_numeric($telefono)) return null;
        $query = "INSERT INTO Utente (Nome, Cognome, DataNascita, ComuneNascita, Telefono, Email, Indirizzo, Citta, Stato, NewsLetter) VALUES (\"$nome\", \"$cognome\", \"$datanascita\", \"$comunenascita\", \"$telefono\", \"$email\", \"$indirizzo\", \"$citta\", \"$stato\", $newsletter);";
        return Database::insertUpdateDelete($query);
    }

    public static function buyTickets($utente, $evento, $data, $biglietti) {
        $data = Database::$connection->real_escape_string($data);
        $query = "INSERT INTO Biglietti (Utente, Evento, Data, NrBiglietti) VALUES ($utente, $evento, \"$data\", $biglietti);";
        return Database::insertUpdateDelete($query);
    }

}