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
        $product_id = $_GET['add-product'] ?? "";
        if (isset($_GET['add-product']))
            $this->addToCart($product_id);
    }

    private function addToCart($product_id)
    {
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
        array_push($_SESSION["cart"], $product_id);
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
