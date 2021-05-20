<?php

class DashboardController
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
        $page = $_GET['page'] ?? "";

        switch ($page) {
            case "dashboard":
                $this->dashboard();
                break;
            case "edit-product":
                $product_id = $_GET['id'] ?? "";
                $this->editProduct($product_id);
                break;
        }
    }

    /**
     *
     */
    public function dashboard()
    {
        if ($_SESSION['isAdmin']) {
            $this->view->viewHeader("Dashboard");
            $this->view->createProductForm();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->processProductForm();
            }
            $products = $this->model->fetchAllProducts();
            $this->view->viewAllProducts($products);
            $this->view->viewFooter();
        } else {
            echo 'Not admin';
        }
    }

    private function processProductForm()
    {
        $product = array(
            "name" => $this->sanitize($_POST['name']),
            "image" => $this->sanitize($_POST['image']),
            "description" => $this->sanitize($_POST['description']),
            "price" => $this->sanitize($_POST['price'])
        );

        $confirm = $this->model->createProduct($product);

        if ($confirm) {
            echo "Det duger.";
        } else {
            echo "Helvete.";
        }
    }

    public function editProduct($product_id)
    {
        if (!$product_id) {
            echo "You need to choose a product";
            die();
        }

        $product = $this->model->fetchProductById($product_id);

        if (!$product) {
            echo "Product ID ($product_id) does not exist";
        } else {
            $this->view->viewHeader("Edit Product");
            $this->view->createProductForm();
            $this->view->viewFooter();
        }
    }
    public function sanitize($text)
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
}
