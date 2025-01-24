<?php 

require_once('../private/initialize.php');

$page_title = 'About Us';
include(SHARED_PATH . '/public_header.php'); 

?>
    <section>
        <p><a href="<?=url_for('/index.php') ?>">Back</a></p>
    </section>
    <section>
        <header>
            <h2>About Us</h2>
        </header>
        <p>Chain Gang was started in 2005 by a group of bicycle loving friends. We wanted to create a neighborhood bike shop that could also deliver top-quality bicycles to your doorstep. Now with six locations around the city, we are able to reach even more neighborhoods.</p>
        <p>Our mechanics inspect every bicycle from top to bottom before it leaves our shop. If you have questions, our expert staff has the knowledge and experience to advise you and to meet all of your cycling needs.</p>
    </section>  

<?php 

$super_hero_image = 'AdobeStock_50633008_xlarge.jpeg';

include(SHARED_PATH . '/public_footer.php'); 

?>
