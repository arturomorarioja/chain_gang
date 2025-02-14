<?php

require_once '../../../private/initialize.php';
requireLogin();

$pageTitle = 'Add bicycle';
$backUrl = '/staff/bicycles';
include SHARED_PATH . '/staff_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $args = $_POST['bicycle'] ?? null;

    $bicycle = new Bicycle($args);
    $result = $bicycle->save();

    if ($result) {
        $newID = $bicycle->id;
        $session->message('The bicycle was created successfully');
        header('Location: ' . urlFor('/staff/bicycles/show.php?id=' . $newID));
    } else {
        if (!empty($bicycle->validationErrors)) {
            $errorMsg = join('<br>', $bicycle->validationErrors);
            $continue = true;
        } else {
            $errorMsg = 'There was an error while creating a new bicycle. ';
        }
        include SHARED_PATH . '/error.php';
    }
}

?>
    
    <form method="POST" action="new.php" novalidate>
        <div>
            <label for="txtBrand">Brand</label>
            <input type="text" name="bicycle[brand]" id="txtBrand" required
                value="<?=h($bicycle->brand ?? '') ?>">
        </div>
        <div>
            <label for="txtModel">Model</label>
            <input type="text" name="bicycle[model]" id="txtModel" required
                value="<?=h($bicycle->model ?? '') ?>">
        </div>
        <div>
            <label for="txtYear">Year</label>
            <input type="number" name="bicycle[year]" id="txtYear" required min="1900" max="<?=date('Y') ?>"
                value="<?=h($bicycle->year ?? '') ?>">
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
            <input type="text" name="bicycle[colour]" id="txtColour" required
                value="<?=h($bicycle->colour ?? '') ?>">
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
            <input type="number" name="bicycle[weight_kg]" id="txtWeight" required
                value="<?=isset($bicycle) ? (float)$bicycle->weightKg() : '' ?>">
        </div>
        <div>
            <label for="txtPrice">Price (USD)</label>
            <input type="number" name="bicycle[price]" id="txtPrice" required
                value="<?=isset($bicycle) ? (float)$bicycle->price : '' ?>">
        </div>
        <div>
            <label for="txtDescription">Description</label>
            <textarea name="bicycle[description]" id="txtDescription"><?=h($bicycle->description ?? '') ?></textarea>
        </div>
        <div>
            <button type="submit">Create bicycle</button>
        </div>
    </form>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>