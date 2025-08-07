<?php

class DatabaseConfig
{
    private $pdo = null;

    public function integrate()
    {
        if ($this->pdo === null) {
            try {
                $server = "localhost";
                $user = "root";
                $password = "";
                $database = "docs_gall";

                $this->pdo = new PDO("mysql:host=$server;dbname=$database", $user, $password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                exit(json_encode([
                    'success' => false,
                    'message' => 'Database connection failed: ' . $e->getMessage()
                ]));
            }
        }

        return $this->pdo;
    }
}

