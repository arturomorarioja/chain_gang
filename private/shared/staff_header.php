<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chain Gang <?php if(isset($page_title)) { echo '- ' . h($page_title); } ?></title>
    <link rel="stylesheet" media="all" href="<?=url_for('/stylesheets/public.css') ?>">
    <link rel="stylesheet" media="all" href="<?=url_for('/stylesheets/staff.css') ?>">
</head>
<body>
    <header>
        <h1>
            <a href="<?=url_for('/index.php') ?>">
                Chain Gang Staff Area
            </a>
        </h1>
    </header>
    <main>