<?php

class DashboardView
{

    public function viewHeader()
    {
        include_once("views/include/header.php");
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
    // Bra att läsa om PHP Templating och HEREDOC syntax!
    // https://css-tricks.com/php-templating-in-just-php/

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
                            <a class="btn btn-danger" href="">Delete</a>
                        </div>
                    </div>
            </div>  <!-- col -->

        HTML;

        echo $html;
    }


    public function viewAllProducts($products)
    {
        foreach ($products as $product) {
            $this->viewOneProduct($product);
        }
    }
}
