<?php

class OrderView
{

    public function viewHeader($title)
    {
        include_once("views/include/header.php");
        include_once("views/include/navbar.php");
    }

    public function viewFooter()
    {
        include_once("views/include/footer.php");
    }


    // Bra att läsa om PHP Templating och HEREDOC syntax!
    // https://css-tricks.com/php-templating-in-just-php/


    public function viewCart($formatedCart)
    {
        $cart = $_SESSION['cart'] ?? array();

        if (count($cart) === 0) {
            echo "<h4>Your cart is empty</h4>";
        } else {
            $cart_string = "<ul class='mt-3 col-12 list-group'>";
            $orderTotal = 0;
            foreach ($formatedCart as $key => $product) {
                $cart_string .= "
                    <li class='list-group-item mb-2' style='height: 80px'>
                        <div class='d-flex h-100'>
                            <img class='img-fluid' src='$product[image]' alt='image'>
                            <div class='h-100 ml-4'>
                               $product[name]
                               <br />
                               $product[price] SEK 
                               <br />
                               Quantity: $product[quantity] 
                            </div>
                        </div>
                    </li>";
                $orderTotal += $product["price"] * $product["quantity"];
            }
            $orderBtn = "<a class='btn mt-2 btn-primary' href='?page=cart&action=order'>
                        Place Order (Price: $orderTotal SEK)</a>";
            echo $cart_string . "</ul>";

            echo $orderBtn;
        }
    }

    public function viewOrderPage($movie)
    {
        $this->viewOneMovie($movie);
        $this->viewOrderForm($movie);
    }


    public function viewOrderForm($movie)
    {
        $html = <<<HTML
            <div class="col-md-6">
            
                <form action="#" method="post">
                    <input type="hidden" name="film_id" 
                            value="$movie[film_id]">

                    <input type="number" name="customer_id" required 
                            class="form-control form-control-lg my-2" 
                            placeholder="Ange ditt kundnummer">
                
                    <input type="submit" class="form-control my-2 btn btn-lg btn-outline-success" 
                            value="Skicka beställningen">
                </form>
                
            <!-- col avslutas efter ett meddelande från viewConfirmMessage eller viewErrorMessage -->

        HTML;

        echo $html;
    }

    public function viewConfirmMessage($customer, $lastInsertId)
    {
        $this->printMessage(
            "<h4>Tack $customer[name]</h4>
            <p>Vi kommer att skicka filmen till följande e-post:</p>
            <p>$customer[email]</p>
            <p>Ditt ordernummer är $lastInsertId </p>
            </div> <!-- col  avslutar Beställningsformulär -->
            ",
            "success"
        );
    }

    public function viewErrorMessage($message)
    {
        $this->printMessage($message, "warning");
    }

    /**
     * En funktion som skriver ut ett felmeddelande
     * $messageType enligt Bootstrap Alerts
     * https://getbootstrap.com/docs/5.0/components/alerts/
     */
    public function printMessage($message, $messageType = "danger")
    {
        $html = <<<HTML
            <div class="my-2 alert alert-$messageType">
                $message
            </div>

        HTML;

        echo $html;
    }
}
