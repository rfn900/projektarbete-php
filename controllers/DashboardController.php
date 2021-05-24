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
        $action = $_GET['action'] ?? "";

        switch ($page) {
            case "dashboard":
                if ($action === "send-order") {
                    $order_id = $_GET['order_id'] ?? "";
                    $this->sendOrder($order_id);
                }
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
        $this->view->viewHeader("Dashboard");
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $this->view->createProductForm();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->processProductForm("create");
            }

            $products = $this->model->fetchAllProducts();
            $orders = $this->model->fetchAllOrders();
            $this->view->viewAllOrders($orders);
            $this->view->viewAllProducts($products);
        } else {
            $this->view->viewErrorMessage('Not Admin');
        }
        $this->view->viewFooter();
    }

    private function sendOrder($order_id)
    {
        $this->model->updateShippedStatus($order_id);
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
            $this->view->viewUpdateConfirmMessage($action);
        } else {
            $this->view->viewUpdateErrorMessage($action);
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
