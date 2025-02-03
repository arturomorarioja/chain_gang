<?php 

require_once '../private/initialize.php';

$pageTitle = 'Inventory';
include SHARED_PATH . '/public_header.php'; 

?>

    <section>
        <p><a href="<?=urlFor('/index.php') ?>">Back</a></p>
    </section>
    <section>
        <section class="intro">
            <header>
                <h2>Our Inventory of Used Bicycles</h2>
            </header>
            <div class="wrapper">
                <img src="<?php echo urlFor('/images/AdobeStock_55807979_thumb.jpeg') ?>">
                <div>
                    <p>Choose the bike you love.</p>
                    <p>We will deliver it to your door and let you try it before you buy it.</p>
                </div>
            </div>
        </section>

        <div class="table">
            <table id="inventory">
                <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Category</th>
                        <th>Gender</th>
                        <th>Color</th>
                        <th class="number">Price</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
<?php

// --- Active Record design pattern ---
// getAll() is called as a static method
$bikes = Bicycle::getAll();
// ---
if (!$bikes) {
    $errorMsg = 'There was an error while retrieving the bicycle list: ' . Bicycle::$lastErrorMessage;
    include SHARED_PATH . '/error.php';                
}

?>
                <?php if ($bikes): ?>
                    <?php foreach($bikes as $bike): ?>
                        <tr>
                            <td><?=h($bike->brand) ?></td>
                            <td><?=h($bike->model) ?></td>
                            <td><?=h($bike->year) ?></td>
                            <td><?=h($bike->category) ?></td>
                            <td><?=h($bike->gender) ?></td>
                            <td><?=h($bike->colour) ?></td>
                            <td class="number"><?=h(formatMoney($bike->price)) ?></td>
                            <td><a href="detail.php?id=<?=$bike->id ?>">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                </tbody>
            </table>
        </div>
    </section>

<?php include(SHARED_PATH . '/public_footer.php'); ?>