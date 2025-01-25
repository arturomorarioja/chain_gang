<?php

require_once 'database.php';

class Bicycles extends Database
{
    public function getAll(): array|false
    {
        $sql =<<<'SQL'
            SELECT 
                nBicycleID AS bicycle_id,
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

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
            
            return $results;
        } catch (\PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }
}