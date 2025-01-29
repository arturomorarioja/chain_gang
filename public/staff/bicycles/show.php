<?php

require_once '../../../private/initialize.php';
include SHARED_PATH . '/staff_header.php';

?>
    
    <section>
        <p><a href="<?=url_for('/staff/bicycles') ?>">Back</a></p>
    </section>

<?php

$bikeID = $_GET['id'] ?? 0;
if ($bikeID === 0) {
?>
    <section class="error">
        <p>Incorrect parameters.</p>
    </section>
<?php    
    exit;
}
// --- Active Record design pattern ---
// getAll() is called as a static method
$bike = Bicycle::getByID($bikeID);
if (!$bike) {
    ?>
    <section class="error">
        <p>There was an error while retrieving bicycle information.</p>
    </section>
<?php    
    exit;
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
            <dd><?=h(money_format('$%i', $bike->price)) ?></dd>
        </dl>
        <dl>
            <dt>Description</dt>
            <dd><?=h($bike->description) ?></dd>
        </dl>
    </section>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>