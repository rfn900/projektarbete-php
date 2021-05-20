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

    public function createProductForm()
    {
        include_once("views/include/create_product.php");
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
