<?php

require_once '../../../private/initialize.php';
$pageTitle = 'Edit bicycle';
$backUrl = '/staff/bicycles';
include SHARED_PATH . '/staff_header.php';

$bicycleID = $_GET['id'] ?? '';

if ($bicycleID === '') {
    header('Location: ' . urlFor('/staff/bicycles/'));
} else {
    $bicycle = Bicycle::getByID($bicycleID);
    if (!$bicycle) {
        $errorMsg = 'There was an error while retrieving bicycle information: ' . Bicycle::$lastErrorMessage;
        include SHARED_PATH . '/error.php';
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = [];
            $args['brand'] = $_POST['brand'] ?? null;
            $args['model'] = $_POST['model'] ?? null;
            $args['year'] = $_POST['year'] ?? null;
            $args['category'] = $_POST['category'] ?? null;
            $args['colour'] = $_POST['colour'] ?? null;
            $args['gender'] = $_POST['gender'] ?? null;
            $args['price'] = $_POST['price'] ?? null;
            $args['weight_kg'] = $_POST['weight_kg'] ?? null;
            $args['condition_id'] = $_POST['condition_id'] ?? null;
            $args['description'] = $_POST['description'] ?? null;
            
            $bicycle = new Bicycle($args);
            $result = $bicycle->mergeAttributes($args);
            $result = $bicycle->save();

            if ($result) {
                $newID = $bicycle->id;
                $_SESSION['message'] = 'The bicycle was created successfully';
                header('Location: ' . urlFor('/staff/bicycles/show.php?id=' . $newID));
            } else {
                $errorMsg = 'There was an error while editing bicycle information.';
                include SHARED_PATH . '/error.php';                        
            }
        }
    }
}

?>
    
    <form method="POST" action="new.php">
        <div>
            <label for="txtBrand">Brand</label>
            <input type="text" name="brand" id="txtBrand" required 
                value="<?=h($bicycle->brand) ?>">
        </div>
        <div>
            <label for="txtModel">Model</label>
            <input type="text" name="model" id="txtModel" required
                value="<?=h($bicycle->model) ?>">
        </div>
        <div>
            <label for="txtYear">Year</label>
            <input type="number" name="year" id="txtYear" required min="1900" max="<?=date('Y') ?>"
                value="<?=h($bicycle->year) ?>">
        </div>
        <div>
            <label for="cmbCategory">Category</label>
            <select name="category" id="cmbCategory">
                <?php foreach (Bicycle::CATEGORIES as $category): ?>
                    <option value="<?=$category ?>" <?=($category === $bicycle->category ? 'selected' : '') ?>>
                        <?=$category ?>
                    </option>
                <?php endforeach; ?>                
            </select>
        </div>
        <div>
            <label for="cmbGender">Gender</label>
            <select name="gender" id="cmbGender">
                <?php foreach (Bicycle::GENDERS as $gender): ?>
                    <option value="<?=$gender ?>" <?=($gender === $bicycle->gender ? 'selected' : '') ?>>
                        <?=$gender ?>
                    </option>
                <?php endforeach; ?>                
            </select>
        </div>
        <div>
            <label for="txtColour">Colour</label>
            <input type="text" name="colour" id="txtColour" required
            value="<?=h($bicycle->colour) ?>">
        </div>
        <div>
            <label for="cmbCondition">Condition</label>
            <select name="condition_id" id="cmbCondition">
                <?php foreach (Bicycle::CONDITION_OPTIONS as $key => $condition): ?>
                    <option value="<?=$key ?>" <?=($condition === $bicycle->condition() ? 'selected' : '') ?>>
                        <?=$condition ?>
                    </option>
                <?php endforeach; ?>                
            </select>
        </div>
        <div>
            <label for="txtWeight">Weight (kgs)</label>
            <input type="number" name="weight_kg" id="txtWeight" required
            value="<?=(float)$bicycle->weightKg() ?>">
        </div>
        <div>
            <label for="txtPrice">Price (USD)</label>
            <input type="number" name="price" id="txtPrice" required
            value="<?=h($bicycle->price) ?>">
        </div>
        <div>
            <label for="txtDescription">Description</label>
            <textarea name="description" id="txtDescription"><?=h($bicycle->description) ?></textarea>
        </div>
        <div>
            <button type="submit">Edit bicycle</button>
        </div>
    </form>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>