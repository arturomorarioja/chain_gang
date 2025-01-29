<?php

class Bicycle 
{
    // --- Active Record design pattern ---
    static protected $database;
    static public string $lastErrorMessage;

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
            foreach ($bikes as $record) {
                $objectArray[] = self::instantiate($record);
            };
            return $objectArray;
        } catch (\PDOException $e) {
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
                nWeightKg AS weight_kg,
                nConditionID AS condition_id,
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
     * @return A Bicycle object
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
    // ---

    public int $id;
    public string $brand;
    public string $model;
    public int $year;
    public string $category;
    public string $colour;
    public string $description;
    public string $gender;
    public float $price;
    protected float $weight_kg;
    protected int $condition_id;

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
        $this->weight_kg = (float)($args['weight_kg'] ?? 0.0);
        $this->condition_id = (int)($args['condition_id'] ?? 3);

        // Caution: allows private/protected properties to be set
        // foreach($args as $k => $v) {
        //   if(property_exists($this, $k)) {
        //     $this->$k = $v;
        //   }
        // }
    }

    public function weightKg(): string
    {
        return number_format($this->weight_kg, 2) . ' kg';
    }

    public function setWeightKg(float $value): void 
    {
        $this->weight_kg = floatval($value);
    }

    public function weightLbs(): string 
    {
        $weight_lbs = floatval($this->weight_kg) * self::WEIGHT_RATIO;
        return number_format($weight_lbs, 2) . ' lbs';
    }

    public function setWeightLbs(float $value): void
    {
       $this->weight_kg = floatval($value) / self::WEIGHT_RATIO;
    }

    public function condition(): string 
    {
        if($this->condition_id > 0) {
            return self::CONDITION_OPTIONS[$this->condition_id];
        } else {
            return 'Unknown';
        }
    }
}