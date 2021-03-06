<?php

class Model
{   
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function fetchUserByName($username) {
      $statement = "SELECT * FROM user WHERE name=:username";
      $parameters = array(':username' => $username);
      $user = $this->db->select($statement, $parameters);
      return $user[0] ?? false;
    }

    public function saveUser($username) {
      //check if user exists
      $user = $this->fetchUserByName($username);
      if ($user) return false;

      //insert to db
      $statement = "INSERT INTO user (name, admin) VALUES (:name, :admin)";
      $parameters = array(
        ':name' => $username,
        ':admin' => 0
      );
      
      $user = $this->db->insert($statement, $parameters);
      
      return $user;
    }

    public function loginUser($username) {
      //check if user exists
      $user = $this->fetchUserByName($username);
      if (!$user) return false;
      return $user;
    }

    public function fetchAllProducts()
    {
        $products = $this->db->select("SELECT * FROM product");
        return $products;
    }
}
