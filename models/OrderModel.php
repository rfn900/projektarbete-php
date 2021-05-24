<?php

class OrderModel
{

    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function fetchProductById($id)
    {
        $statement = "SELECT * FROM product WHERE id = :id";
        $params = array(":id" => $id);
        $product = $this->db->select($statement, $params);
        return $product[0] ?? false;
    }

    public function fetchCustomerById($id)
    {
        $statement = "SELECT * FROM customers WHERE customer_id=:id";
        $parameters = array(':id' => $id);
        $customer = $this->db->select($statement, $parameters);
        return $customer[0] ?? false;
    }

    public function getLastOrderId()
    {
        $statement = "SELECT MAX(id) AS max_id FROM orders";
        $lastOrderId = $this->db->returnLastInsertedId($statement);
        return $lastOrderId;
    }

    public function saveOrder($customer_id, $order_id, $product_id, $quantity)
    {
        $shipped = 0;
        $statement = "INSERT INTO orders (id, product_id, user_id, shipped, quantity)  
                      VALUES (:order_id, :product_id, :customer_id, :shipped, :quantity)";

        $parameters = array(
            ':order_id' => $order_id,
            ':product_id' => $product_id,
            ':customer_id' => $customer_id,
            ':shipped' => $shipped,
            ':quantity' => $quantity
        );

        // Ordernummer
        $lastInsertId = $this->db->insert($statement, $parameters);

        return array('customer' => $customer_id, 'lastInsertId' => $lastInsertId);
    }
}
