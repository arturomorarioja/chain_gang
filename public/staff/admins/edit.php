<?php

require_once '../../../private/initialize.php';
requireLogin();

$pageTitle = 'Edit admin';
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
            $args = $_POST['admin'] ?? null;
            
            $admin = new admin($args);
            $admin->id = $adminID;
            $admin->mergeAttributes($args);
            $result = $admin->save();

            if ($result) {
                $_SESSION['message'] = 'The admin was edited successfully';
                header('Location: ' . urlFor('/staff/admins/show.php?id=' . $adminID));
            } else {
                if (!empty($admin->validationErrors)) {
                    $errorMsg = join('<br>', $admin->validationErrors);
                    $continue = true;
                } else {
                    $errorMsg = 'There was an error while editing admin information.';
                }
                include SHARED_PATH . '/error.php';                        
            }
        }
    }
}

?>
    
    <form method="POST" action="<?=urlFor('/staff/admins/edit.php?id=' . h(u($adminID))) ?>" novalidate>
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
            <button type="submit">Edit admin</button>
        </div>
    </form>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>