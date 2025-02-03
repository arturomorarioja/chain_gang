    <section class="error">
        <p><?=$errorMsg ?></p>
    </section>
<?php 

$continue = $continue ?? false;
if (!$continue) {
    exit; 
}

?>