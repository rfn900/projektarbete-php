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
                if ($action == "order")
                    $this->placeOrder();
                break;
        }
    }

    private function placeOrder()
    {
        $user = $_SESSION["user"] ?? "";
        $customer_id = $_SESSION["user"]["id"] ?? "";
        $customer_name = $_SESSION["user"]["name"] ?? "";

        $formatedCart = $_SESSION["formatedCart"] ?? array();
        if (!$user) {
            $this->view->viewErrorMessage("You need to be logged in to place an order!");
        } else {
            $lastOrderId = $this->model->getLastOrderId();
            $orderId = $lastOrderId + 1;
            $confirmation = true;
            foreach ($formatedCart as $key => $product) {
                $savedOrder = $this->model->saveOrder($customer_id, $orderId, $product["id"], $product["quantity"]);
                if (!$savedOrder)
                    $confirmation = false;
            }

            if ($confirmation) {
                unset($_SESSION['formatedCart']);
                unset($_SESSION['cart']);
                $this->view->viewOrderConfirmation($orderId, $customer_name);
            } else {
                $this->view->viewErrorMessage("Order not sent!");
            }
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
        $index = 0;
        foreach ($preFormatedCart as $key => $quantity) {
            // fetch from database according to id
            $product = $this->model->fetchProductById($key);
            if ($product) {
                $formatedCart[$index]['id'] = $product['id'];
                $formatedCart[$index]['name'] = $product['name'];
                $formatedCart[$index]['image'] = $product['image'];
                $formatedCart[$index]['description'] = $product['description'];
                $formatedCart[$index]['price'] = $product['price'];
                $formatedCart[$index]['quantity'] = $quantity;
            }
            $index += 1;
        }
        //echo "<pre>";
        //print_r($formatedCart);
        //echo "</pre>";
        $_SESSION["formatedCart"] = $formatedCart;
        $this->view->viewHeader("Cart");
        //echo "This is cart";
        $this->view->viewCart($formatedCart);
        $this->view->viewFooter();
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
