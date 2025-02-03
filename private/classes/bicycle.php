<?php

class Bicycle 
{
    public int $id;
    public string $brand;
    public string $model;
    public int $year;
    public string $category;
    public string $colour;
    public string $description;
    public string $gender;
    public float $price;
    protected float $weightKg;
    protected int $conditionID;

    public const CATEGORIES = ['Road', 'Mountain', 'Hybrid', 'Cruiser', 'City', 'BMX'];
    public const GENDERS = ['Mens', 'Womens', 'Unisex'];
    public const CONDITION_OPTIONS = [
        1 => 'Beat up',
        2 => 'Decent',
        3 => 'Good',
        4 => 'Great',
        5 => 'Like New'
    ];
    private const WEIGHT_RATIO = 2.2046226218;

    public function __construct($args=[])
    {
        $this->brand = $args['brand'] ?? '';
        $this->model = $args['model'] ?? '';
        $this->year = (int)($args['year'] ?? '');
        $this->category = $args['category'] ?? '';
        $this->colour = $args['colour'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->gender = $args['gender'] ?? '';
        $this->price = (float)($args['price'] ?? 0);
        $this->weightKg = (float)($args['weight_kg'] ?? 0.0);
        $this->conditionID = (int)($args['condition_id'] ?? 3);

        // Caution: allows private/protected properties to be set
        // foreach($args as $k => $v) {
        //   if(property_exists($this, $k)) {
        //     $this->$k = $v;
        //   }
        // }
    }

    public function weightKg(): string
    {
        return number_format($this->weightKg, 2) . ' kg';
    }

    public function setWeightKg(float $value): void 
    {
        $this->weightKg = floatval($value);
    }

    public function weightLbs(): string 
    {
        $weight_lbs = floatval($this->weightKg) * self::WEIGHT_RATIO;
        return number_format($weight_lbs, 2) . ' lbs';
    }

    public function setWeightLbs(float $value): void
    {
       $this->weightKg = floatval($value) / self::WEIGHT_RATIO;
    }

    public function condition(): string 
    {
        if($this->conditionID > 0) {
            return self::CONDITION_OPTIONS[$this->conditionID];
        } else {
            return 'Unknown';
        }
    }

    /*******************************
     * Active record design pattern
     *******************************/

    static protected Database $database;
    static public    string   $lastErrorMessage;    
    public           array    $validationErrors = [];
    static protected array    $dbColumns = [
        'cBrand', 'cModel', 'nYear', 'cCategory', 'cGender', 
        'cColour', 'nPrice', 'nWeightKg', 'nConditionID', 'cDescription'
    ];    
 
    static public function setDatabase($database)
    {
        self::$database = $database;
    }
 
     /**
      * Retrieves all bicycle models.
      * Notice how $database and $lastErrorMessage are called statically 
      * due to the use of the active record pattern
      * @return  An associative array with bicycle models, 
      *          or false if there was an error
      */
    static public function getAll(): array|false
    {
        $sql =<<<'SQL'
            SELECT 
                nBicycleID AS id,
                cBrand AS brand,
                cModel AS model,
                nYear AS year,
                cCategory AS category,
                cGender AS gender,
                cColour AS colour,
                nPrice AS price,
                nWeightKg AS weight_kg,
                nConditionID AS condition_id,
                cDescription AS description
            FROM bicycles
            ORDER BY cBrand, cModel, nYear, cCategory;
        SQL;
        try {   
            $objectArray = [];
            $bikes = self::$database->execute($sql);
            if ($bikes) {
                foreach ($bikes as $record) {
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
      * Retrieves a single bicycle.
      * @param $bicycleID The ID of the bicycle whose information to retrieve
      * @return An associative array with the bicycle's information,
      *         or false if there was an error
      */
    static public function getByID(int $bicycleID): Bicycle|false
    {
        $sql =<<<'SQL'
            SELECT 
                cBrand AS brand,
                cModel AS model,
                nYear AS year,
                cCategory AS category,
                cGender AS gender,
                cColour AS colour,
                nPrice AS price,
                nWeightKg AS weightKg,
                nConditionID AS conditionID,
                cDescription AS description
            FROM bicycles
            WHERE nBicycleID = ?;
        SQL;
        try {
            $bike = self::$database->execute($sql, [$bicycleID], true);
            if (!$bike) {
                self::$lastErrorMessage = Database::$lastErrorMessage;
                return false;    
            }
            return self::instantiate($bike);
        } catch (\PDOException $e) {
            self::$lastErrorMessage = $e->getMessage();
            return false;
        }
    }
 
     /**
      * It creates a Bicycle object.
      * @param $record An associative array with the values to create the object from
      * @return Bicycle A Bicycle object
      */
    static protected function instantiate(array $record): Bicycle
    {
        $bicycleObject = new self;
 
        foreach ($record as $property => $value) {
            if (property_exists($bicycleObject, $property)) {
                $bicycleObject->$property = $value;
            }
        }
        return $bicycleObject;
    }

    /**
     * Validates all attributes before a create or update operation
     */
    protected function validate(): void
    {
        $this->validationErrors = [];

        if (isBlank($this->brand)) {
            $this->validationErrors[] = 'The brand cannot be blank.';
        }
        if (isBlank($this->model)) {
            $this->validationErrors[] = 'The model cannot be blank.';
        }
        ////
    }

    /**
     * If the id attribute is set, it updates a bicycle.
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
     * It inserts a database row into the database
     * @return true if the operation was successful, false otherwise
     */
    protected function create(): bool
    {
        $attributes = $this->attributes();
        $columns = join(', ', array_keys($attributes));
        $sql =<<<SQL
            INSERT INTO bicycles
                ($columns)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
        SQL;
        $params = array_values($attributes);
        try {
            $result = self::$database->execute($sql, $params);
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
     * It creates an associative array whose keys are the 
     * table columns and whose values are the table attributes
     * @return array<string, mixed> The array 
     */
    public function attributes(): array
    {
        $attributes = [];
        foreach(self::$dbColumns as $column) {
            if ($column !== 'nBicycleID') {
                $attrName = strtolower(substr($column, 1, 1)) . substr($column, 2);
                $attributes[$column] = $this->$attrName;
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
        $columns = join(' = ?, ', array_keys($attributes));
        $sql =<<<SQL
            UPDATE bicycles
            SET $columns
            WHERE nBicycleID = ?;
        SQL;
        $params = array_values($attributes);
        $params['nBicycleID'] = $this->id;

        try {
            $result = self::$database->execute($sql, $params);
            
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
}