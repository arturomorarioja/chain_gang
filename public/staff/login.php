<?php

require_once '../../private/initialize.php';

$pageTitle = 'Log in';
$backUrl = '/staff';
include SHARED_PATH . '/staff_header.php';

$validationErrors = [];
$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '') {
        $validationErrors[] = 'Username cannot be empty.';
    }
    if ($password === '') {
        $validationErrors[] = 'Password cannot be empty.';
    }

    if (empty($validationErrors)) {
        $admin = Admin::getByUsername($username);
        if ($admin && $admin->verifyPassword($password)) {
            $session->login($admin);
            header('Location: '. urlFor('/staff/index.php'));
        } else {
            $validationErrors[] = 'Log in was unsuccessful.';
        }
    }
}

?>

    <section>
        <?=displayErrors($validationErrors) ?>

        <form action="login.php" method="POST">
            <div>
                <label for="txtUsername">Username</label>
                <input type="text" name="username" id="txtUsername"
                    value="<?=h($username) ?>">
            </div>
            <div>
                <label for="txtPassword">Password</label>
                <input type="password" name="password" id="txtPassword"
                    value="<?=h($password) ?>">
            </div>
            <div>
                <button type="submit">Log in</button>
            </div>
        </form>
    </section>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>