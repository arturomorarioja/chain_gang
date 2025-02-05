<?php

require_once '../../../private/initialize.php';
$pageTitle = 'Delete bicycle';
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
            if ($bicycle->delete()) {
                $_SESSION['message'] = 'The bicycle was deleted successfully';
                header('Location: ' . urlFor('/staff/bicycles'));
            } else {
                $errorMsg = 'There was an error while deleting the bicycle.';
                include SHARED_PATH . '/error.php';                        
            }
        }
    }
}

?>
    
    <section>
        <p>Are you sure that you want to delete this bicycle?</p>
    </section>
    <section>
        <dl>
            <dt>Brand</dt>
            <dd><?=h($bicycle->brand) ?></dd>
        </dl>
        <dl>
            <dt>Model</dt>
            <dd><?=h($bicycle->model) ?></dd>
        </dl>
        <dl>
            <dt>Year</dt>
            <dd><?=h($bicycle->year) ?></dd>
        </dl>
        <dl>
            <dt>Category</dt>
            <dd><?=h($bicycle->category) ?></dd>
        </dl>
        <dl>
            <dt>Gender</dt>
            <dd><?=h($bicycle->gender) ?></dd>
        </dl>
        <dl>
            <dt>Colour</dt>
            <dd><?=h($bicycle->colour) ?></dd>
        </dl>
        <dl>
            <dt>Weight</dt>
            <dd><?=h($bicycle->weightKg()) . ' / ' . h($bicycle->weightLbs()) ?></dd>
        </dl>
        <dl>
            <dt>Condition</dt>
            <dd><?=h($bicycle->condition()) ?></dd>
        </dl>
        <dl>
            <dt>Price</dt>
            <dd><?=h(formatMoney($bicycle->price)) ?></dd>
        </dl>
        <dl>
            <dt>Description</dt>
            <dd><?=h($bicycle->description) ?></dd>
        </dl>
    </section>
    <form method="POST" action="<?=urlFor('/staff/bicycles/delete.php?id=' . h(u($bicycleID))) ?>">
        <div>
            <button type="submit">Delete bicycle</button>
        </div>
    </form>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>