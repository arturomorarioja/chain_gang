<?php 

require_once('../../private/initialize.php');
include(SHARED_PATH . '/staff_header.php');

?>

<nav>
    <ul id="menu">
        <li><a href="<?=url_for('/staff/bicycles') ?>">Bicycles</a></li>
    </ul>    
</nav>

<?php 

include(SHARED_PATH . '/staff_footer.php'); 

?>