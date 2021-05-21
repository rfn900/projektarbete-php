<?php
session_start();

require_once("models/Database.php");
require_once("models/Model.php");
require_once("models/DashboardModel.php");
require_once("models/OrderModel.php");

require_once("views/View.php");
require_once("views/DashboardView.php");
require_once("views/OrderView.php");

require_once("controllers/Controller.php");
require_once("controllers/DashboardController.php");
require_once("controllers/OrderController.php");


$database   = new Database("webbshop", "user", "user");
$orderModel = new OrderModel($database);
$orderView  = new OrderView();
$orderController = new OrderController($orderModel, $orderView);

$model      = new Model($database);
$view       = new View();
$controller = new Controller($model, $view);

$dashboardModel = new DashboardModel($database);
$dashboardView  = new DashboardView();
$dashboardController = new DashboardController($dashboardModel, $dashboardView);
