<?php 

require_once('../private/initialize.php');

$page_title = 'Inventory';
include(SHARED_PATH . '/public_header.php'); 

?>

    <section>
        <p><a href="<?=url_for('/index.php') ?>">Back</a></p>
    </section>
    <section>
        <section class="intro">
            <header>
                <h2>Our Inventory of Used Bicycles</h2>
            </header>
            <div class="wrapper">
                <img class="inset" src="<?php echo url_for('/images/AdobeStock_55807979_thumb.jpeg') ?>">
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
                        <th>Weight</th>
                        <th>Condition</th>
                        <th class="number">Price</th>
                    </tr>
                </thead>
                <tbody>
<?php

$parser = new ParseCSV(PRIVATE_PATH . '/used_bicycles.csv');
$bike_array = $parser->parse();

?>
                <?php foreach($bike_array as $args): ?>
                    <?php $bike = new Bicycle($args); ?>
                    <tr>
                        <td><?=h($bike->brand) ?></td>
                        <td><?=h($bike->model) ?></td>
                        <td><?=h($bike->year) ?></td>
                        <td><?=h($bike->category) ?></td>
                        <td><?=h($bike->gender) ?></td>
                        <td><?=h($bike->color) ?></td>
                        <td><?=h($bike->weight_kg()) . ' / ' . h($bike->weight_lbs()) ?></td>
                        <td><?=h($bike->condition()) ?></td>
                        <td class="number"><?=h(money_format('$%i', $bike->price)) ?></td>
                    </tr>
                <?php endforeach; ?>
                
                </tbody>
            </table>
        </div>
    </section>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
