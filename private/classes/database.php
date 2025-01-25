<?php

require_once 'db_credentials.php';

class Database extends DBCredentials
{
    protected ?PDO $pdo;
    public string $lastErrorMessage;

    public function __construct()
    {
        $dsn = 'mysql:host=' . self::DB_SERVER . ';dbname=' . self::DB_NAME . ';charset=utf8';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = @new PDO($dsn, self::DB_USER, self::DB_PASSWORD, $options);
        } catch (\PDOException $e) {
            $this->lastErrorMessage = 'Connection unsuccessful: ' . $e->getMessage();
            exit;
        }
    }

    public function disconnect(): void
    {
        $this->pdo = null;
    }
}