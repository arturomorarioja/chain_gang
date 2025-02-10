<?php

require_once '../../../private/initialize.php';

$pageTitle = 'Admins';
$backUrl = '/staff';
include SHARED_PATH . '/staff_header.php';

// --- Active Record design pattern ---
// getAll() is called as a static method
$admins = Admin::getAll();
// ---
if (!$admins) {
    $errorMsg = 'There was an error while retrieving the admin list: ' . Admin::$lastErrorMessage;
    include SHARED_PATH . '/error.php';
}

?>

    <section>
        <section>
            <p><a href="new.php">Add admin</a></p>
        </section>
        <div class="table">
            <table class="list">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($admins): ?>
                        <?php foreach($admins as $admin): ?>
                            <tr>
                                <td><?=h($admin->id) ?></td>
                                <td><?=h($admin->firstName) ?></td>
                                <td><?=h($admin->lastName) ?></td>
                                <td><?=h($admin->email) ?></td>
                                <td><?=h($admin->username) ?></td>
                                <td><a href="show.php?id=<?=$admin->id ?>">View</a></td>
                                <td><a href="edit.php?id=<?=$admin->id ?>">Edit</a></td>
                                <td><a href="delete.php?id=<?=$admin->id ?>">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
                