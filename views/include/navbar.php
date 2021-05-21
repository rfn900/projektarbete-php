<?php
$cart = $_SESSION['cart'] ?? array();
$nInCart = count($cart);
$logInOrOut = isset($_SESSION['user']) ? "logout" : "login";
$html = <<<HTML

            <div class="navbar">
                <a href="?page=$logInOrOut">$logInOrOut</a>
                <a href="?page=dashboard">dashboard</a>
                <a href='?page=cart'>
                    <span class='bg-white px-2 py-2 mr-2 rounded-circle'>
                        🛒
                    </span>
                    $nInCart
                </a>

            </div> 
            <h1 class="text-center">
                <a href="index.php">
                    Webbshop
                </a>
            </h1>
            <div class="row">
        
        HTML;

echo $html;
