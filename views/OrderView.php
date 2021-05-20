<?php

class OrderView
{

    public function viewHeader($title)
    {
        include_once("views/include/header.php");
    }

    public function viewFooter()
    {
        include_once("views/include/footer.php");
    }

    
    // Bra att läsa om PHP Templating och HEREDOC syntax!
    // https://css-tricks.com/php-templating-in-just-php/

    public function viewOneMovie($movie)
    {
        $html = <<<HTML
            <div class="col-md-6">
                    <div class="card m-1">
                        <img class="card-img-top" src="$url/images/$movie[image]" 
                             alt="$movie[title]">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h4>$movie[title]</h4>
                                <h5>Pris: $movie[price] kr</h5>
                            </div>
                        </div>
                    </div>
            </div>  <!-- col -->

        HTML;

        echo $html;
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

    public function viewErrorMessage($customer_id)
    {
        $this->printMessage(
            "<h4>Kundnummer $customer_id finns ej i vårt kundregister!</h4>
            <h5>Kontakta kundtjänst</h5>
            </div> <!-- col  avslutar Beställningsformulär -->
            ",
            "warning"
        );
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
