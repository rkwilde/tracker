<?php
    $hasPage = !empty($pageName);
    $signedIn = isset($_SESSION['signedInID']);
?>
<!DOCTYPE html>
<html>

<head>

    <title>Health Tracker<?= $hasPage ? " - $pageName" : "" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="view/css/styles.css">

</head>

<body>

    <header class="gradient1">
        <a id="logo-link" class="
                <?= $signedIn ? "margin-left-section2" : "margin-left-section" ?>" 
                href="index.php">
            <img id="logo" src="view/images/logo.png" alt="Health Tracker">
        </a>
        <a href="<?= $signedIn ? "index.php?page=signout" : "index.php?page=signup" ?>" >
            <span id="userControls"
                    class="button link-styled-header hover-hand float-right 
                        <?= $signedIn ? "margin-right-section2" : "margin-right-section" ?>
                        padding-all-small text-bold color-accent1-bg">
                <?= $signedIn ? "Sign Out" : "Get Started" ?>
            </span>
        </a>
        <?php 
            // if(!$signedIn) {
                ?>
<!--                     <span id="headerLinks" class="float-right margin-right-small2">
                        <a class="link-plain padding-sides-small" href="index.php?page=about">About</a> | 
                        <a class="link-plain padding-sides-small" href="index.php?page=contact">Contact</a> | 
                    </span> -->
                <?php 
            // }
        ?>
    </header>
