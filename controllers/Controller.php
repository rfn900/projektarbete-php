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
      case "login":
        $this->login();
        break;
      case "register":
        $this->registerUser();
        break;
      case "":
        $this->displayProducts();
        break;
    }
  }

  private function registerUser()
  {
    $this->view->viewHeader("Välkommen");

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
      $this->processUserForm();

    $this->view->viewCreateUser();
    $this->view->viewFooter();
  }

  private function login()
  {
    $this->view->viewHeader("Logga in");

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
      $this->processLoginForm();
    // TODO: Fix if statement here
    $this->view->viewLoginUser();
    $this->view->viewFooter();
  }

  private function processUserForm()
  {
    $user = $this->sanitize($_POST['username']);

    $confirm = $this->model->saveUser($user);

    if ($confirm) {
      $this->view->viewConfirmMessage();
    } else {
      $this->view->viewErrorMessage("Användaren finns redan");
    }
  }

  private function processLoginForm()
  {
    $username = $this->sanitize($_POST['username']);

    $user = $this->model->loginUser($username);

    if ($user) {
      // auth successful
      $_SESSION['user'] = $user;
      //$_SESSION['isAdmin'] = $user["admin"] ? true : false; 
      //Check is user is admin or not
      if ($user["admin"]) {
        $_SESSION["isAdmin"] = true;
      } else {
        $_SESSION["isAdmin"] = false;
      }
    } else {
      $this->view->viewErrorMessage("login failed");
    }
  }

  private function displayProducts()
  {

    $this->view->viewHeader("Webbshop");
    $products = $this->model->fetchAllProducts();
    $this->view->viewAllProducts($products);
    $this->view->viewFooter();
  }

  public function sanitize($text)
  {
    $text = trim($text);
    $text = stripslashes($text);
    $text = htmlspecialchars($text);
    return $text;
  }
}
