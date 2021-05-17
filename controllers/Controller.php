<?php

class Controller
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
            /* case "":
                $this->getAllMovies();
                break; */
            case "":
                $this->login();
                break;
        }
    }

    private function login() {
      $this->view->viewHeader("Välkommen");
      $this->view->viewCreateUser();
      $this->view->viewFooter();
    }
}
