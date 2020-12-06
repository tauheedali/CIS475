<?php
require_once('autoload.php');

use CIS475\Services\Auth;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title; ?></title>
    <meta charset="UTF-8">
    <?php foreach ($meta as $key => $value): ?>
        <meta name="<?= $key; ?>" content="<?= $value; ?>">
    <?php endforeach; ?>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@4.1.1/dist/css/bootstrap-grid.min.css"/>
    <link href="<?= $baseUrl; ?>css/style.css?ver=<?= date('U'); ?>" rel="stylesheet"/>
    <link href="<?= $baseUrl; ?>css/slick-valid.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</head>
<body>
<nav>
    <div class="container">
        <div id="logo">
            <a href="<?= $baseUrl; ?>">
                <img src="images/logo.png" alt="Tauheed Ali">
            </a>
        </div>
        <div id="navigation">
            <?php foreach ($links as $link): ?>
                <a href="<?= $link['url']; ?>"><?= $link['title']; ?></a>
            <?php endforeach; ?>
            <?php if(Auth::verifyLogin()):?>
                <?php foreach ($authLinks as $link): ?>
                    <a href="<?= $link['url']; ?>"><?= $link['title']; ?></a>
                <?php endforeach; ?>

            <?php else:?>
                <?php foreach ($nonAuthLinks as $link): ?>
                    <a href="<?= $link['url']; ?>"><?= $link['title']; ?></a>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</nav>