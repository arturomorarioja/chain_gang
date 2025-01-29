<?php 

require_once('../private/initialize.php');
include(SHARED_PATH . '/public_header.php');

?>

<nav>
    <ul id="menu">
        <li><a href="<?=urlFor('/bicycles.php') ?>">View Our Inventory</a></li>
        <li><a href="<?=urlFor('/about.php') ?>">About Us</a></li>
    </ul>    
</nav>

<?php 

$super_hero_image = 'AdobeStock_18040381_xlarge.jpeg';

include(SHARED_PATH . '/public_footer.php'); 

?>