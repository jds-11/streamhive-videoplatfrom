<?php
class Database
{
    private $connection;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';
        $host     = $config['host'];
        $port     = $config['port'];
        $dbname   = $config['dbname'];
        $username = $config['username'];
        $password = $config['password'];

        try {
            $this->connection = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
                $username,
                $password
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            echo "";
        } catch (PDOException $e) {
            die("Connectie mislukt: " . $e->getMessage());
        }
    }

    public function connect()
    {
        return $this->connection;
    }

    public function query(string $sql, array $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}