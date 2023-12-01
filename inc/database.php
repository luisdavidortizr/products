<?php
class Database {

    private $connection;

    function __construct() {
        $this->connect_db();
    }

    public function connect_db() {
        $this->connection = mysqli_connect('localhost', 'root', '', 'productsdb');

        if(mysqli_connect_error()) {
            die('Database connection failed'.mysqli_connect_error());
        }
    }

    public function execute($query) {
        $result = $this->connection->query($query);
        if($result == false) {
            echo "Error: cannot execute query";
            return false;
        }
        return true;
    }

    public function getData($query) {
        $result = $this->connection->query($query);
    
        if ($result === false) {
            echo "Error: " . $this->connection->error;
            return false;
        }
    
        $rows = array();
    
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    
        return $rows;
    }

    public function exec($query) {
        return $this->connection->query($query);
    }
}

$database = new Database();
?>