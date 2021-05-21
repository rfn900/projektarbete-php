<?php

class View
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

    public function viewCreateUser()
    {
        $html = <<<HTML
        
            <div class="col-md-12">
              <form method="post" action="">
                <div class="form-group">
                  <label for="username">
                  <input type="text" id="username" name="username"/>
                  <input type="submit" value="skapa användare">
                </div>
              </form>
            </div>  <!-- col -->

        HTML;

        echo $html;
    }

    public function viewConfirmMessage()
    {
        $this->printMessage(
            "<h4>Användare skapad</h4>",
            "success"
        );
    }

    public function viewErrorMessage($errorMessage)
    {
        $this->printMessage(
            "<h4>$errorMessage</h4>",
            "warning"
        );
    }

    public function printMessage($message, $messageType = "danger")
    {
        $html = <<<HTML
            <div class="my-2 alert alert-$messageType">
                $message
            </div>

        HTML;

        echo $html;
    }

    public function showLogout()
    {
        $html = <<<HTML
            <div class="my-2 alert">
                You have been logged out. Hope to see you again soon...
            </div>
            <div>
                <a href="?">Back to the shop</a>
            </div>
        HTML;

        echo $html;
    }


    public function viewLoginUser()
    {
        $html = <<<HTML
        
            <div class="col-md-12">
              <form method="post" action="">
                <div class="form-group">
                  <label for="username">
                  <input type="text" id="username" name="username"/>
                  <input type="submit" value="logga in">
                </div>
              </form>
            </div>  <!-- col -->

        HTML;

        echo $html;
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
                            <form action="?action=addtocart" method="POST">
                                <input type="text" hidden value="$product[id]" name="id"/>
                                <input type="submit" class="btn btn-primary" value="Lägg till varukorg">
                            </form>
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
