<?php

class DashboardModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function fetchAllProducts()
    {
        $products = $this->db->select("SELECT * FROM product");
        return $products;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function createProduct($product)
    {
        $statement = "INSERT INTO product (name, image, description, price) VALUES (:name, :image, :description, :price)";
        $parameters = array(
            ":name" => $product["name"],
            ":image" => $product["image"],
            ":description" => $product["description"],
            ":price" => $product["price"]
        );
        $lastInsertId = $this->db->insert($statement, $parameters);
        return $lastInsertId;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function updateProduct($product)
    {
        return null;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function deleteProduct($product)
    {
        return null;
    }
}
