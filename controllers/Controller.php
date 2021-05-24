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
      case "logout":
        $this->logout();
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

    if (!isset($_SESSION['user'])) {
      $this->view->viewLoginUser();
    } else {
      echo $this->view->viewErrorMessage('You are already logged in');
    }
    $this->view->viewFooter();
  }

  private function logout()
  {
    session_destroy();
    session_unset();
    header("Location: ?");
  }

  private function processUserForm()
  {
    $user = $this->sanitize($_POST['username']);

    if ($user) {
      $confirm = $this->model->saveUser($user);

      if ($confirm) {
        $this->view->viewConfirmMessage();
      } else {
        $this->view->viewErrorMessage("User already registered");
      }
    } else {
      $this->view->viewErrorMessage("This field cannot be empty");
    }
  }

  private function processLoginForm()
  {
    $username = $this->sanitize($_POST['username']);
    $errorMessage = $username ? "login failed" : "Field cannot be empty";

    $user = $this->model->loginUser($username);

    if ($user) {
      // auth successful
      $_SESSION['user'] = $user;
      //Check is user is admin or not
      if ($user["admin"]) {
        $_SESSION["isAdmin"] = true;
      } else {
        $_SESSION["isAdmin"] = false;
      }
      header("Location: ?");
    } else {
      $this->view->viewErrorMessage($errorMessage);
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
