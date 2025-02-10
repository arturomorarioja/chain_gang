<?php 

require_once '../../../private/initialize.php';

$pageTitle = 'Bicycles';
$backUrl = '/staff';
include SHARED_PATH . '/staff_header.php'; 

// --- Active Record design pattern ---
// getAll() is called as a static method
$bikes = Bicycle::getAll();
// ---
if (!$bikes) {
    $errorMsg = 'There was an error while retrieving the bicycle list: ' . Bicycle::$lastErrorMessage;
    include SHARED_PATH . '/error.php';                
}

?>

    <section>
        <section>
            <p><a href="new.php">Add bicycle</a></p>
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
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
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
                            <td><a href="show.php?id=<?=$bike->id ?>">View</a></td>
                            <td><a href="edit.php?id=<?=$bike->id ?>">Edit</a></td>
                            <td><a href="delete.php?id=<?=$bike->id ?>">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
