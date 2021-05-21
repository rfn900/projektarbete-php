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
        <a href="?page=dashboard">dashboard</a>
        <?php
        $cart = $_SESSION['cart'] ?? array();
        echo "<a href='?page=cart'><span class='bg-white px-2 py-2 rounded-circle'>🛒</span> " . count($cart) . " items" . "</a>";
        ?>
    </div>
    <h1 class="text-center">
        <a href="index.php">
            Webbshop
        </a>
    </h1>
    <div class="row">
