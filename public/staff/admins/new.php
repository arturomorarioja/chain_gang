<?php

require_once '../../../private/initialize.php';
requireLogin();

$pageTitle = 'Add admin';
$backUrl = '/staff/admins';
include SHARED_PATH . '/staff_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $args = $_POST['admin'] ?? null;

    $admin = new Admin($args);
    $result = $admin->save();

    if ($result) {
        $newID = $admin->id;
        $_SESSION['message'] = 'The admin was created successfully';
        header('Location: ' . urlFor('/staff/admins/show.php?id=' . $newID));
    } else {
        if (!empty($admin->validationErrors)) {
            $errorMsg = join('<br>', $admin->validationErrors);
            $continue = true;
        } else {
            $errorMsg = 'There was an error while creating a new admin. ';
        }
        include SHARED_PATH . '/error.php';
    }
}

?>
    
    <form method="POST" action="new.php" novalidate>
        <div>
            <label for="txtFirstName">First name</label>
            <input type="text" name="admin[first_name]" id="txtFirstName" required
                value="<?=h($admin->firstName ?? '') ?>">
        </div>
        <div>
            <label for="txtLastName">Last name</label>
            <input type="text" name="admin[last_name]" id="txtLastName" required
                value="<?=h($admin->lastName ?? '') ?>">
        </div>
        <div>
            <label for="txtEmail">Email</label>
            <input type="email" name="admin[email]" id="txtEmail" required
                value="<?=h($admin->email ?? '') ?>">
        </div>
        <div>
            <label for="txtUsername">Username</label>
            <input type="text" name="admin[username]" id="txtUsername" required
                value="<?=h($admin->username ?? '') ?>">
        </div>
        <div>
            <label for="txtPassword">Password</label>
            <input type="password" name="admin[password]" id="txtPassword" required
                value="<?=h($admin->password ?? '') ?>">
        </div>
        <div>
            <label for="txtConfirmedPassword">Confirm password</label>
            <input type="password" name="admin[confirmed_password]" id="txtConfirmedPassword" required
                value="<?=h($admin->confirmedPassword ?? '') ?>">
        </div>
        <div>
            <button type="submit">Create admin</button>
        </div>
    </form>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>