<?php

class Model
{   
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }
}
