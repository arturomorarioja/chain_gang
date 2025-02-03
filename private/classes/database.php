<?php

require_once 'db_credentials.php';

class Database extends DBCredentials
{
    static public ?PDO $pdo;
    static public string $lastErrorMessage = '';

    public function __construct()
    {
        $dsn = 'mysql:host=' . self::DB_SERVER . ';dbname=' . self::DB_NAME . ';charset=utf8';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            self::$pdo = @new PDO($dsn, self::DB_USER, self::DB_PASSWORD, $options);
        } catch (\PDOException $e) {
            self::$lastErrorMessage = 'Connection unsuccessful: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * Runs a SQL query
     * @param $sql       The query to run
     * @param $params    An associative array with the list of parameters
     * @param $returnOne If true and the query is a SELECT, it only returns one row
     * @return array<string, mixed>
     *         If it is a SELECT:            the query results as an associative array.
     *         If it is an INSERT:           the ID of the newly added row.
     *         If it is an UPDATE or DELETE: the number of affected rows.
     *         If there is an error:         false
     */
    public function execute(string $sql, array $params = [], $returnOne = false): array|int|false
    {
        foreach ($params as $key => $param) {
            $params[$key] = htmlspecialchars($param);
        }
        try {
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);

            // SELECT statement
            if ($stmt->columnCount() > 0) { 
                if ($returnOne) {
                    $results = $stmt->fetch();
                } else {
                    $results = $stmt->fetchAll();
                }
            } else {    // DML statement
                $results = self::$pdo->lastInsertId();  // INSERT
                if ((int)$results === 0) {  // UPDATE or DELETE
                    $results = $stmt->rowCount();
                }
            }
            return $results;
        } catch (\PDOException $e) {
            self::$lastErrorMessage = 'Error executing query: ' . $e->getMessage();
            return false;
        }
    }

    public function disconnect(): void
    {
        $this->pdo = null;
    }
}