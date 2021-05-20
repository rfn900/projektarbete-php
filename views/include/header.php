<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webbshop</title>
    <link rel="stylesheet" href="styles/bootstrap.css">
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body class="container">
    <div class="navbar">
        <a href="?page=login">login</a>
        <a href="">Home</a>
        <?php
            if (isset($_SESSION["cart"]))
            echo "<p>In cart: " . count($_SESSION["cart"]) . " items" . "</p>";
        ?>
    </div>
    <h1 class="text-center">
        <a href="index.php">
            Webbshop
        </a>
    </h1>
    <div class="row">
