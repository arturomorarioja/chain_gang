<?php if(isset($super_hero_image)): ?>
    
        <section class="hero">
            <img 
                id="super-hero-image" 
                src="<?=url_for('/images/' . $super_hero_image) ?>"
            >
        </section>
    </main>
    <footer>
        <?php include(SHARED_PATH . '/public_copyright_disclaimer.php'); ?>
    </footer>
    
<?php else: ?>

    </main>
    <footer>
        <?php include(SHARED_PATH . '/public_copyright_disclaimer.php'); ?>
    </footer>
    
<?php endif; ?>

</body>
</html>
