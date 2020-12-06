<?php

namespace CIS475\Classes;
require_once 'autoload.php';

use CIS475\Classes\Database;

class Phone extends Database
{
    public $id;
    public $personID;
    public $phone;
    
    public function __construct($data = NULL)
    {
        parent::__construct();
        $this->bootstrapTable();
    }
    
    protected function bootstrapTable()
    {
        $tableExists = self::db()->query('SHOW TABLES LIKE "phonesTable"')->fetch_row();
        if (empty($tableExists)) {
            $createResult = self::db()->query(
                "CREATE TABLE phonesTable (
phoneID INT AUTO_INCREMENT PRIMARY KEY,
personID INT,
personPhone VARCHAR(10) NOT NULL,
FOREIGN KEY (personID)
    REFERENCES peopleTable(personID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);");
            if ($createResult) {
                return TRUE;
            }
            die('error creating phonesTable');
        }
    }
    
    public static function validate($data)
    {
        $errors = [];
        if (empty($data['phone']) || !preg_match('/^\d{10}$/', ($data['phone']))) {
            $errors[] = '<p>Phone number is required and should be no longer that 10 numeric characters.</p>';
        }
        
        return $errors;
    }
    
    public static function findByPersonID($personID)
    {
        $phone = new self();
        $stmnt = self::db()->prepare('SELECT * FROM phonesTable WHERE personID = ?');
        $stmnt->bind_param('i', $personID);
        $stmnt->execute();
        $phoneData = $stmnt->get_result()->fetch_assoc();
        if (isset($phone)) {
            $phone->id = $phoneData['phoneID'];
            $phone->personID = $phoneData['personID'];
            $phone->phone = $phoneData['personPhone'];
            
            return $phone;
        }
    }
    
    public function save()
    {
        if (isset($this->id)) {
            $updateQuery = "UPDATE phonesTable SET personID=?, personPhone=? WHERE phoneID=?";
            $stmnt = self::db()->prepare($updateQuery);
            $stmnt->bind_param('isi', $this->personID, $phone, $this->id);
            $stmnt->execute();
        } else {
            $insertQuery = "INSERT INTO phonesTable (personID,personPhone) VALUES (?,?)";
            $stmnt = self::db()->prepare($insertQuery);
            echo self::db()->error;
            $stmnt->bind_param('is', $this->personID, $this->phone);
            if ($stmnt->execute()) {
                $this->id = self::db()->insert_id;
            }
        }
    }
    
}