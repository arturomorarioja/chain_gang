<?php

class Bicycle extends Database
{
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

    public function __construct(array $args=[])
    {
        parent::__construct();
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

    static protected string $tableName = 'bicycles';
    static protected string $primaryKeyColumn = 'nBicycleID';
    static protected array  $columns = [
        'nBicycleID' => 'id', 
        'cBrand' => 'brand', 
        'cModel' => 'model', 
        'nYear' => 'year', 
        'cCategory' => 'category', 
        'cGender' => 'gender', 
        'cColour' => 'colour', 
        'nPrice' => 'price', 
        'nWeightKg' => 'weightKg', 
        'nConditionID' => 'conditionID', 
        'cDescription' => 'description', 
    ];
    static protected array $sortColumns = [
        'cBrand', 'cModel', 'nYear', 'cCategory'
    ];
 
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
        $year = (int)$this->year;
        if ($year < 1850) {
            $this->validationErrors[] = 'The year cannot be lower than 1850.';
        } 
        if ($year > date('Y')) {
            $this->validationErrors[] = 'The year cannot be later than the present year.';
        }
        if (!in_array($this->category, self::CATEGORIES)) {
            $this->validationErrors[] = 'Invalid category.';
        }
        if (!in_array($this->gender, self::GENDERS)) {
            $this->validationErrors[] = 'Invalid gender.';
        }
        if (isBlank($this->colour)) {
            $this->validationErrors[] = 'The colour cannot be blank.';
        }
        if (!in_array($this->conditionID, array_keys(self::CONDITION_OPTIONS))) {
            $this->validationErrors[] = 'Invalid condition.';
        }
        if ((float)$this->weightKg <= 0) {
            $this->validationErrors[] = 'The weight must be positive.';
        }
        if ((float)$this->price <= 0) {
            $this->validationErrors[] = 'The price must be positive.';
        }
    }
}