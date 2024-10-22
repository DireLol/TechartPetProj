<?php

namespace App\Kernel\Database;

use App\Kernel\Config\ConfigInterface;
use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    private PDO $pdo;

    public function __construct(
        private ConfigInterface $config
    ) {
        $this->connect();
    }

    private function connect(): void
    {
        $driver = $this->config->get('database.driver');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port');
        $database = $this->config->get('database.database');
        $username = $this->config->get('database.username');
        $password = $this->config->get('database.password');
        $charset = $this->config->get('database.charset');
        $dsn = "$driver:host=$host;dbname=$database;charset=$charset;port=$port";

        try {
            $this->pdo = new PDO(
                $dsn,
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $exception) {
            exit("Database connection failed: {$exception->getMessage()}");
        }

    }

    public function prepare(string $sql): \PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    public function query(string $sql): \PDOStatement
    {
        return $this->pdo->query($sql);
    }
}
