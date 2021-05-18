<?php

class DashboardController
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
            case "dashboard":
                $this->dashboard();
                break;
        }
    }

    /**
     *
     */
    public function dashboard()
    {
        if ($_SESSION['isAdmin']) {
            echo 'Admin here';
        } else {
            echo 'Not admin';
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
