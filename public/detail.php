<?php

require_once '../private/initialize.php';

$pageTitle = 'Detail';
include SHARED_PATH . '/public_header.php';

?>
    
    <section>
        <p><a href="<?=urlFor('/bicycles.php') ?>">Back</a></p>
    </section>

<?php

$bikeID = $_GET['id'] ?? 0;
if ($bikeID === 0) {
    $errorMsg = 'Incorrect parameters.';
    include SHARED_PATH . '/error.php';
}

// --- Active Record design pattern ---
// getAll() is called as a static method
$bike = Bicycle::getByID($bikeID);
if (!$bike) {
    $errorMsg = 'There was an error while retrieving bicycle information.';
    include SHARED_PATH . '/error.php';
}
// ---

?>

    <section>
        <dl>
            <dt>Brand</dt>
            <dd><?=h($bike->brand) ?></dd>
        </dl>
        <dl>
            <dt>Model</dt>
            <dd><?=h($bike->model) ?></dd>
        </dl>
        <dl>
            <dt>Year</dt>
            <dd><?=h($bike->year) ?></dd>
        </dl>
        <dl>
            <dt>Category</dt>
            <dd><?=h($bike->category) ?></dd>
        </dl>
        <dl>
            <dt>Gender</dt>
            <dd><?=h($bike->gender) ?></dd>
        </dl>
        <dl>
            <dt>Colour</dt>
            <dd><?=h($bike->colour) ?></dd>
        </dl>
        <dl>
            <dt>Weight</dt>
            <dd><?=h($bike->weightKg()) . ' / ' . h($bike->weightLbs()) ?></dd>
        </dl>
        <dl>
            <dt>Condition</dt>
            <dd><?=h($bike->condition()) ?></dd>
        </dl>
        <dl>
            <dt>Price</dt>
            <dd><?=h(formatMoney($bike->price)) ?></dd>
        </dl>
        <dl>
            <dt>Description</dt>
            <dd><?=h($bike->description) ?></dd>
        </dl>
    </section>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
