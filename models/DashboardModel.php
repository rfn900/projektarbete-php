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

    public function fetchProductById($id)
    {
        $statement = "SELECT * FROM product WHERE id = :id";
        $params = array(":id" => $id);
        $product = $this->db->select($statement, $params);
        return $product[0] ?? false;
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
        $statement = "UPDATE product SET  
                        name=:name,
                        image=:image,
                        description=:description,
                        price=:price
                        WHERE id=:id";
        $parameters = array(
            ":id" => $product["id"],
            ":name" => $product["name"],
            ":image" => $product["image"],
            ":description" => $product["description"],
            ":price" => $product["price"]
        );
        $this->db->update($statement, $parameters);
        return true;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function deleteProduct($product_id)
    {
        $statement = "DELETE FROM product WHERE id = :id";
        $params = array(
            ":id" => $product_id
        );
        $this->db->delete($statement, $params);
        // redirect to dashboard
    }
}
