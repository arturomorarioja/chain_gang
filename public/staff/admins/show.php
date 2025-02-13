<?php

require_once '../../../private/initialize.php';
requireLogin();

$pageTitle = 'Admins';
$backUrl = '/staff/admins';
include SHARED_PATH . '/staff_header.php'; 

$adminID = $_GET['id'] ?? 0;
if ($adminID === 0) {
    $errorMsg = 'Incorrect parameters.';
    include SHARED_PATH . '/error.php';
}
// --- Active Record design pattern ---
// getByID() is called as a static method
$admin = Admin::getByID($adminID);
// ---
if (!$admin) {
    $errorMsg = 'There was an error while retrieving admin information: ' . Admin::$lastErrorMessage;
    include SHARED_PATH . '/error.php';                
}

?>

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

<?php include(SHARED_PATH . '/staff_footer.php'); ?>