<?php

class DashboardView
{

    public function viewHeader()
    {
        include_once("views/include/header.php");
        include_once("views/include/navbar.php");
    }

    public function viewFooter()
    {
        include_once("views/include/footer.php");
    }


    public function createProductForm($product = null)
    {
        $test = $_GET['page'] === "edit-product" ? "Update" : "Add";
        $name = $_GET['page'] === "edit-product" ? $product['name'] : "";
        $image = $_GET['page'] === "edit-product" ? $product['image'] : "";
        $description = $_GET['page'] === "edit-product" ? $product['description'] : "";
        $price = $_GET['page'] === "edit-product" ? $product['price'] : "";

        $html = <<<HTML
            <h4> $test product here</h4>
            <form action="#" method="post" class="row mb-5">
                <div class="col-md-5">
                    <input type="text" value="$name" name="name" class="form-control mt-2" required placeholder="Product Name">
                </div>
                <div class="col-md-5">
                    <input type="text" value="$image" name="image" class="form-control mt-2" required placeholder="Image URL">
                </div>
                <div class="col-md-5">
                    <input type="text" value="$description" name="description" class="form-control mt-2" required placeholder="Description">
                </div>
                <div class="col-md-5">
                    <input type="text" value="$price" name="price" class="form-control mt-2" required placeholder="Price">
                </div>
                <div class="col-md-2">
                    <input type="submit" class="form-control mt-2 btn btn-outline-primary" value="Save Product">
                </div>
            </form>      
        HTML;

        echo $html;
    }

    public function viewOneOrder($order)
    {
        $status = $order['shipped'] ? "Shipped" : "Not shipped";
        $disabled = $order['shipped'] ? "disabled" : "";
        $shippedBtn = $order['shipped'] ? "Order Sent" : "Ship Order";
        $primaryOrNot = $order['shipped'] ? "btn-secondary" : "btn-primary";
        $html = <<<HTML
           
            <li class="d-flex justify-content-between mb-2 list-group-item">                
               <div> 
                <h5>
                    Order Number: $order[id]
                </h5>
                <p>
                    Order status: $status
                </p>
                </div>
                <div>

                <a href="?page=dashboard&action=send-order&order_id=$order[id]" class="btn $disabled $primaryOrNot">$shippedBtn</a>
                </div>
            </li>

        HTML;

        echo $html;
    }

    public function viewAllOrders($orders)
    {

        echo "<h3 class='col-md-12 mb-4'>All Orders:</h3>";
        echo  "<div class='col-md-6 mb-5'><ul class='list-group'>";
        foreach ($orders as $order) {
            $this->viewOneOrder($order);
        }
        echo  "</div></ul>";
    }

    public function viewOneProduct($product)
    {
        $html = <<<HTML
            <div class="col-md-6">
                    <div class="card m-1">
                        <img class="card-img-top" src="$product[image]" 
                            alt="$product[image]">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>$product[name]</h4>
                            </div>
                            <div class="card-text">
                              <p>$product[description]</p>
                              <p>$product[price] SEK</p>
                            </div>
                            <a class="btn btn-warning" href="?page=edit-product&id=$product[id]">Edit</a>
                            <a class="btn btn-danger" href="?page=delete-product&id=$product[id]">Delete</a>
                        </div>
                    </div>
            </div>  <!-- col -->

        HTML;

        echo $html;
    }


    public function viewAllProducts($products)
    {
        echo "<h3 class='mb-4 col-md-12'>All Products:</h3>";
        foreach ($products as $product) {
            $this->viewOneProduct($product);
        }
    }

    public function viewErrorMessage($message)
    {
        echo "<h4 class='my-2 alert col-md-12 alert-warning'>$message</h4>";
    }

    public function viewUpdateConfirmMessage($action)
    {
        $message = $action === "edit" ? "Product updated" : "Product Created";
        $this->printMessage(
            "<h4>$message</h4>",
            "success",
            $action
        );
    }

    public function viewUpdatErrorMessage($action)
    {
        $message = $action === "edit" ? "Update failed" : "Product updated";
        $this->printMessage(
            "<h4>$message</h4>",
            "warning",
            $action
        );
    }


    public function printMessage($message, $messageType = "danger", $action)
    {
        $link = $action === "edit" ?
            "<p><a href='?page=dashboard'>Back to Dashboard</a></p>" :
            "";

        $html = <<<HTML
            <div class="my-2 alert col-md-12 alert-$messageType">
                $message
            </div>
            $link

        HTML;

        echo $html;
    }
}
