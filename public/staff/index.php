<?php 

require_once('../../private/initialize.php');
requireLogin();

$pageTitle = '';
include(SHARED_PATH . '/staff_header.php');

?>

<nav>
    <ul id="menu">
        <li><a href="<?=urlFor('/staff/bicycles') ?>">Bicycles</a></li>
        <li><a href="<?=urlFor('/staff/admins') ?>">Admins</a></li>
    </ul>    
</nav>

<?php 

include(SHARED_PATH . '/staff_footer.php'); 

?>