<?php

class Bicycle 
{
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
        //$this->brand = isset($args['brand']) ? $args['brand'] : '';
        $this->brand = $args['brand'] ?? '';
        $this->model = $args['model'] ?? '';
        $this->year = $args['year'] ?? '';
        $this->category = $args['category'] ?? '';
        $this->colour = $args['colour'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->gender = $args['gender'] ?? '';
        $this->price = $args['price'] ?? 0;
        $this->weight_kg = $args['weight_kg'] ?? 0.0;
        $this->condition_id = $args['condition_id'] ?? 3;

        // Caution: allows private/protected properties to be set
        // foreach($args as $k => $v) {
        //   if(property_exists($this, $k)) {
        //     $this->$k = $v;
        //   }
        // }
    }

    public function weight_kg(): string
    {
        return number_format($this->weight_kg, 2) . ' kg';
    }

    public function set_weight_kg(float $value): void 
    {
        $this->weight_kg = floatval($value);
    }

    public function weight_lbs(): string 
    {
        $weight_lbs = floatval($this->weight_kg) * self::WEIGHT_RATIO;
        return number_format($weight_lbs, 2) . ' lbs';
    }

    public function set_weight_lbs(float $value) 
    {
       $this->weight_kg = floatval($value) / self::WEIGHT_RATIO;
    }

    public function condition(): string 
    {
        if($this->condition_id > 0) {
            return self::CONDITION_OPTIONS[$this->condition_id];
        } else {
            return "Unknown";
        }
    }
}