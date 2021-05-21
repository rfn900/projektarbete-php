<?php

class OrderController
{

    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
        $this->router();
    }

    private function router()
    {
        $action = $_GET['action'] ?? "";

        if ($action == "addtocart")
            $this->addToCart();

        $page = $_GET['page'] ?? "";

        switch ($page) {
            case "cart":
                $this->cart();
                break;
        }
    }

    private function addToCart()
    {

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $this->sanitize($_POST["id"]);
            // Redirect to Dashboard
            array_push($_SESSION["cart"], $product_id);
        }
    }

    /**
     * undocumented function
     *
     */
    private function cart()
    {
        $cart = $_SESSION['cart'] ?? array();
        $preFormatedCart = array_count_values($cart);
        $formatedCart = array();
        foreach ($preFormatedCart as $key => $quantity) {
            // fetch from database according to id
            $product = $this->model->fetchProductById($key);
            if ($product) {
                $formatedCart[$key]['id'] = $product['id'];
                $formatedCart[$key]['name'] = $product['name'];
                $formatedCart[$key]['image'] = $product['image'];
                $formatedCart[$key]['description'] = $product['description'];
                $formatedCart[$key]['price'] = $product['price'];
                $formatedCart[$key]['quantity'] = $quantity;
            }
        }
        //echo "<pre>";
        //print_r($formatedCart);
        //echo "</pre>";

        $this->view->viewHeader("Cart");
        echo "This is cart";
        $this->view->viewFooter();
    }


    private function processOrderForm()
    {
        $movie_id    = $this->sanitize($_POST['film_id']);
        $customer_id = $this->sanitize($_POST['customer_id']);
        $confirm = $this->model->saveOrder($customer_id, $movie_id);

        if ($confirm) {
            $customer = $confirm['customer'];
            $lastInsertId = $confirm['lastInsertId'];
            $this->view->viewConfirmMessage($customer, $lastInsertId);
        } else {
            $this->view->viewErrorMessage($customer_id);
        }
    }

    /**
     * Sanitize Inputs
     * https://www.w3schools.com/php/php_form_validation.asp
     */
    public function sanitize($text)
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
}
