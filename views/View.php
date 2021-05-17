<?php

class View
{

    public function viewHeader($title)
    {
        include_once("views/include/header.php");
    }

    public function viewFooter()
    {
        include_once("views/include/footer.php");
    }

    public function viewAboutPage()
    {
        include_once("views/include/about.php");
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

    public function viewLoginUser() {
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

    public function viewAllMovies($movies)
    {
        foreach ($movies as $movie) {
            $this->viewOneMovie($movie);
        }
    }

}
