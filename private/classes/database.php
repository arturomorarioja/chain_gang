<?php

require_once 'db_credentials.php';

class Database extends DBCredentials
{    
    static protected ?PDO $pdo;
    static protected string $tableName = '';
    static protected string $primaryKeyColumn = '';
    static protected array $columns = [];
    static public string $lastErrorMessage = '';
    public int $id;

    /**
     * A connection to the database is open upon object instantiation
     */
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
     * @param $orderCols An array with the name of the columns to sort the results by
     * @return array<string, mixed>
     *         If it is a SELECT:            the query results as an associative array.
     *         If it is an INSERT:           the ID of the newly added row.
     *         If it is an UPDATE or DELETE: the number of affected rows.
     *         If there is an error:         false
     */
    protected function execute(
        string $sql, 
        array $params = [], 
        bool $returnOne = false,
        array $orderCols = []
    ): array|int|false
    {
        foreach ($params as $key => $param) {
            $params[$key] = htmlspecialchars($param);
        }
        try {
            if (count($orderCols) > 0) {
                $sql .= ' ORDER BY ' . join(', ', $orderCols);
            }
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

    /**
     * Retrieves all table rows.
     * @return  An associative array with all table rows, 
     *          or false if there was an error
     */
    static public function getAll(): array|false
    {
        $tableName = static::$tableName;
        $columns = static::columnsForSelect();
        $sql =<<<SQL
            SELECT $columns
            FROM $tableName
            ORDER BY cBrand, cModel, nYear, cCategory;
        SQL;
        try {   
            $objectArray = [];
            $db = new static();
            $rows = $db->execute($sql);
            if ($rows) {
                foreach ($rows as $record) {
                    $objectArray[] = self::instantiate($record);
                };
                return $objectArray;
            } else {
                self::$lastErrorMessage = 'Incorrect query execution.';
                return false;
            }
        } catch (Exception $e) {
            self::$lastErrorMessage = $e->getMessage();
            return false;
        }
    }    

 
    /**
     * Retrieves a single row
     * @param $rowID The ID of the row whose information to retrieve
     * @return A child class object with the row's information,
     *         or false if there was an error
     */
    static public function getByID(int $rowID): static|false
    {
        $tableName = static::$tableName;
        $columns = static::columnsForSelect();
        $primaryKeyColumn = static::$primaryKeyColumn;
        $sql =<<<SQL
            SELECT $columns
            FROM $tableName
            WHERE $primaryKeyColumn = ?;
        SQL;
     
        try {
            $db = new static();
            $row = $db->execute($sql, [$rowID], true);
            if (!$row) {
                self::$lastErrorMessage = Database::$lastErrorMessage;
                return false;    
            }
            return self::instantiate($row);
        } catch (\PDOException $e) {
            self::$lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    /**
     * Data validation prior to inserting or updating a row.
     * To be implemented in each child class
     */
    protected function validate(): void
    {        
    }

    /**
     * If the id attribute is set, it updates a row.
     * If the id attribute is not, it inserts a new one.
     * @return true if the process was successful, false otherwise
     */
    public function save(): bool
    {
        $this->validate();
        if (!empty($this->validationErrors)) {
            return false;
        }

        if (isset($this->id)) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    /**
     * It inserts a table row into the database
     * @return true if the operation was successful, false otherwise
     */
    protected function create(): bool
    {
        $columns = self::columnsForUpdate();
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $columns = join(', ', array_keys($columns));
        $tableName = static::$tableName;
        $sql =<<<SQL
            INSERT INTO $tableName
                ($columns)
            VALUES
                ($placeholders);
        SQL;
        $params = array_values($this->attributes());

        try {
            $result = self::execute($sql, $params);
            if ($result) {
                $this->id = $result;
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            self::$lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    /**
     * It creates an associative array whose keys are the table
     * columns and whose values are the values of the class attributes
     * @return array<string, mixed> The array 
     */
    public function attributes(): array
    {
        $attributes = [];
        foreach(static::$columns as $column => $attribute) {
            if ($column !== static::$primaryKeyColumn) {
                // Table column names are translated to class attribute names
                // (e.g., "cName" becomes "name")
                $attrName = strtolower(substr($column, 1, 1)) . substr($column, 2);
                $attributes[$attrName] = $this->$attrName;
            }            
        }
        return $attributes;
    }

    /**
     * It updates a row in the database
     * @return true if the edition was successful, false otherwise
     */
    protected function update(): bool
    {
        $attributes = $this->attributes();
        $columns = self::columnsForUpdate();
        $columns = join(' = ?, ', array_keys($columns));
        $tableName = static::$tableName;
        $primaryKeyColumn = static::$primaryKeyColumn;
        $sql =<<<SQL
            UPDATE $tableName
            SET $columns = ?
            WHERE $primaryKeyColumn = ?;
        SQL;
        $params = array_values($attributes);
        $params[] = $this->id;

        try {
            $result = self::execute($sql, $params);
            
            // The result is the rowcount
            if ($result === 1) {  
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            self::$lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    /**
     * It returns the list of table columns and aliases in SQL SELECT format
     * @return string with the list of table columns
     */
    static private function columnsForSelect(): string
    {
        return implode(
            ', ', 
            array_map(
                fn($key, $value) => $key . ' AS ' . $value, 
                array_keys(static::$columns),
                static::$columns
            )
        );
    }

    /**
     * It returns an array with the list of columns except the primary key
     * @return array with the list of columns
     */
    static private function columnsForUpdate(): array
    {
        // The primary key is removed from the list of columns
        return array_filter(
            static::$columns, 
            fn($value, $key) => $key !== static::$primaryKeyColumn, 
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * It assigns values to the instance properties
     * @args An array with the property values
     */
    public function mergeAttributes(array $args=[]): void
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }       

    /**
     * It creates a table object.
     * @param $record A child instance with the values to create the object from
     * @return A class object
     */
    static protected function instantiate(array $record): Object
    {
        $object = new static();
 
        foreach ($record as $property => $value) {
            if (property_exists($object, $property)) {
                $object->$property = $value;
            }
        }
        return $object;
    }

    /**
     * It deletes a row in the database
     * @return true if the edition was successful, false otherwise
     */
    public function delete(): bool
    {
        $tableName = static::$tableName;
        $primaryKeyColumn = static::$primaryKeyColumn;
        $sql =<<<SQL
            DELETE FROM $tableName
            WHERE $primaryKeyColumn = ?;
        SQL;

        try {
            $result = self::execute($sql, [$this->id]);
            
            // The result is the rowcount
            if ($result === 1) {  
                return true;
            } else {
                self::$lastErrorMessage = 'No row was deleted.';
                return false;
            }
        } catch (\PDOException $e) {
            self::$lastErrorMessage = $e->getMessage();
            return false;
        }
    }
}