<?php 

require_once('../../private/initialize.php');
$pageTitle = '';
include(SHARED_PATH . '/staff_header.php');

?>

<nav>
    <ul id="menu">
        <li><a href="<?=urlFor('/staff/bicycles') ?>">Bicycles</a></li>
    </ul>    
</nav>

<?php 

include(SHARED_PATH . '/staff_footer.php'); 

?>