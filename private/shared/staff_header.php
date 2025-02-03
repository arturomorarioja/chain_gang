<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chain Gang <?php if(isset($pageTitle)) { echo '- ' . h($pageTitle); } ?></title>
    <link rel="stylesheet" media="all" href="<?=urlFor('/stylesheets/public.css') ?>">
    <link rel="stylesheet" media="all" href="<?=urlFor('/stylesheets/staff.css') ?>">
</head>
<body>
    <header>
        <h1>
            <a href="<?=urlFor('/index.php') ?>">
                Chain Gang Staff Area
            </a>
        </h1>
    </header>
    <main>
        <section>
            <p><a href="<?=urlFor($backUrl ?? '/') ?>">Back</a></p>
        </section>
        <header>
            <h2><?=$pageTitle ?></h2>
        </header>