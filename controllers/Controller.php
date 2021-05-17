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

      if ($_SERVER['REQUEST_METHOD'] === 'POST')
          $this->processUserForm();

      $this->view->viewCreateUser();
      $this->view->viewFooter();
    }

    private function processUserForm() {
      $user = $this->sanitize($_POST['username']);
      $confirm = $this->model->saveUser($user);

      if ($confirm) {
        $this->view->viewConfirmMessage();
      } else {
        $this->view->viewErrorMessage();
      }
    }

    public function sanitize($text)
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
}
