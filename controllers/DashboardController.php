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
                $this->renderEditProduct($product_id);
                break;
            case "delete-product":
                $product_id = $_GET['id'] ?? "";
                $this->renderDeleteProduct($product_id);
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
            $this->view->viewNavBar();
            $this->view->createProductForm();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->processProductForm("create");
            }
            $products = $this->model->fetchAllProducts();
            $this->view->viewAllProducts($products);
            $this->view->viewFooter();
        } else {
            echo 'Not admin';
        }
    }

    private function processProductForm($action)
    {
        $id = $_GET['id'] ?? "";
        $product = array(
            "id" => $this->sanitize($id),
            "name" => $this->sanitize($_POST['name']),
            "image" => $this->sanitize($_POST['image']),
            "description" => $this->sanitize($_POST['description']),
            "price" => $this->sanitize($_POST['price'])
        );
        if ($action === "create")
            $confirm = $this->model->createProduct($product);
        else if ($action === "edit")
            $confirm = $this->model->updateProduct($product);

        if ($confirm) {
            $this->view->viewConfirmMessage($action);
        } else {
            $this->view->viewErrorMessage($action);
        }
    }

    public function renderEditProduct($product_id)
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
            $this->view->viewNavBar();
            $this->view->createProductForm($product);
            $this->view->viewFooter();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processProductForm("edit");
            // Redirect to Dashboard
        }
    }

    public function renderDeleteProduct($product_id)
    {
        if (!$product_id) {
            echo "You need to choose a product";
            die();
        }
        $this->model->deleteProduct($product_id);
    }

    public function sanitize($text)
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
}
