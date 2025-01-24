<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chain Gang <?php if(isset($page_title)) { echo '- ' . h($page_title); } ?></title>
    <link rel="stylesheet" media="all" href="<?=url_for('/stylesheets/public.css') ?>">
</head>
<body>
    <header>
        <h1>
            <a href="<?=url_for('/index.php') ?>">
                <img class="bike-icon" src="<?=url_for('/images/USDOT_bicycle_symbol.svg') ?>"><br>
                Chain Gang
            </a>
        </h1>
    </header>
    <main>