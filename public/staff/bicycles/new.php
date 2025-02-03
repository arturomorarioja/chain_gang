<?php

require_once '../../../private/initialize.php';
$pageTitle = 'Add bicycle';
$backUrl = '/staff/bicycles';
include SHARED_PATH . '/staff_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $args = $_POST['bicycle'] ?? null;

    $bicycle = new Bicycle($args);
    $result = $bicycle->save();

    if ($result) {
        $newID = $bicycle->id;
        $_SESSION['message'] = 'The bicycle was created successfully';
        header('Location: ' . urlFor('/staff/bicycles/show.php?id=' . $newID));
    } else {
        $errorMsg = 'There was an error while creating a new bicycle. ';
        include SHARED_PATH . '/error.php';
    }
}

?>
    
    <form method="POST" action="new.php">
        <div>
            <label for="txtBrand">Brand</label>
            <input type="text" name="bicycle[brand]" id="txtBrand" required>
        </div>
        <div>
            <label for="txtModel">Model</label>
            <input type="text" name="bicycle[model]" id="txtModel" required>
        </div>
        <div>
            <label for="txtYear">Year</label>
            <input type="number" name="bicycle[year]" id="txtYear" required min="1900" max="<?=date('Y') ?>">
        </div>
        <div>
            <label for="cmbCategory">Category</label>
            <select name="bicycle[category]" id="cmbCategory">
                <?php foreach (Bicycle::CATEGORIES as $category): ?>
                    <option value="<?=$category ?>"><?=$category ?></option>
                <?php endforeach; ?>                
            </select>
        </div>
        <div>
            <label for="cmbGender">Gender</label>
            <select name="bicycle[gender]" id="cmbGender">
                <?php foreach (Bicycle::GENDERS as $gender): ?>
                    <option value="<?=$gender ?>"><?=$gender ?></option>
                <?php endforeach; ?>                
            </select>
        </div>
        <div>
            <label for="txtColour">Colour</label>
            <input type="text" name="bicycle[colour]" id="txtColour" required>
        </div>
        <div>
            <label for="cmbCondition">Condition</label>
            <select name="bicycle[condition_id]" id="cmbCondition">
                <?php foreach (Bicycle::CONDITION_OPTIONS as $key => $condition): ?>
                    <option value="<?=$key ?>"><?=$condition ?></option>
                <?php endforeach; ?>                
            </select>
        </div>
        <div>
            <label for="txtWeight">Weight (kgs)</label>
            <input type="number" name="bicycle[weight_kg]" id="txtWeight" required>
        </div>
        <div>
            <label for="txtPrice">Price (USD)</label>
            <input type="number" name="bicycle[price]" id="txtPrice" required>
        </div>
        <div>
            <label for="txtDescription">Description</label>
            <textarea name="bicycle[description]" id="txtDescription"></textarea>
        </div>
        <div>
            <button type="submit">Create bicycle</button>
        </div>
    </form>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>