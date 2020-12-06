<?php

namespace CIS475\Classes;
require_once 'autoload.php';

class Database
{
    protected static $instance = NULL;
    protected static $db;
    private $conn;
    
    public function __construct()
    {
        $this->conn = dbConnect();
        //        $instance = self::getInstance();
    }
    
    public static function db()
    {
        $instance = self::getInstance();
        
        return $instance->getConnection();
    }
    
    public static function getInstance()
    {
        if (!self::$instance) { // If no instance then make one
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    public function getConnection()
    {
        $instance = self::getInstance();
        
        return $instance->conn;
    }
    
}