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
        return null;
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
