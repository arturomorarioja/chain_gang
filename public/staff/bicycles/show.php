<?php

require_once '../../../private/initialize.php';
$pageTitle = 'Bicycle';
$backUrl = '/staff/bicycles';
include SHARED_PATH . '/staff_header.php'; 

$bikeID = $_GET['id'] ?? 0;
if ($bikeID === 0) {
    $errorMsg = 'Incorrect parameters.';
    include SHARED_PATH . '/error.php';
}
// --- Active Record design pattern ---
// getByID() is called as a static method
$bike = Bicycle::getByID($bikeID);
// ---
if (!$bike) {
    $errorMsg = 'There was an error while retrieving bicycle information: ' . Bicycle::$lastErrorMessage;
    include SHARED_PATH . '/error.php';                
}

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

<?php include(SHARED_PATH . '/staff_footer.php'); ?>