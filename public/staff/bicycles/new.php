<?php

require_once '../../../private/initialize.php';
include SHARED_PATH . '/staff_header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}

?>
    
    <section>
        <p><a href="<?=urlFor('/staff/bicycles') ?>">Back</a></p>
    </section>
    <header>
        <h2>Add bicycle</h2>
    </header>
    <form id="frmAddBicycle">
        <div>
            <input type="text" >
        </div>
    </form>

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