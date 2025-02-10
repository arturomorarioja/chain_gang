<?php

require_once '../../../private/initialize.php';
$pageTitle = 'Delete admin';
$backUrl = '/staff/admins';
include SHARED_PATH . '/staff_header.php';

$adminID = $_GET['id'] ?? '';

if ($adminID === '') {
    header('Location: ' . urlFor('/staff/admins/'));
} else {
    $admin = Admin::getByID($adminID);
    if (!$admin) {
        $errorMsg = 'There was an error while retrieving admin information: ' . Admin::$lastErrorMessage;
        include SHARED_PATH . '/error.php';
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($admin->delete()) {
                $_SESSION['message'] = 'The admin was deleted successfully';
                header('Location: ' . urlFor('/staff/admins'));
            } else {
                $errorMsg = 'There was an error while deleting the admin.';
                include SHARED_PATH . '/error.php';                        
            }
        }
    }
}

?>
    
    <section>
        <p>Are you sure that you want to delete this admin?</p>
    </section>
    <section>
    <dl>
            <dt>ID</dt>
            <dd><?=h($admin->id) ?></dd>
        </dl>
        <dl>
            <dt>First name</dt>
            <dd><?=h($admin->firstName) ?></dd>
        </dl>
        <dl>
            <dt>Last name</dt>
            <dd><?=h($admin->lastName) ?></dd>
        </dl>
        <dl>
            <dt>Email</dt>
            <dd><?=h($admin->email) ?></dd>
        </dl>
        <dl>
            <dt>Username</dt>
            <dd><?=h($admin->username) ?></dd>
        </dl>
    </section>
    <form method="POST" action="<?=urlFor('/staff/admins/delete.php?id=' . h(u($adminID))) ?>">
        <div>
            <button type="submit">Delete admin</button>
        </div>
    </form>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>