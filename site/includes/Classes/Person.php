<?php

namespace CIS475\Classes;
require_once 'autoload.php';

use CIS475\Classes\Database;

class Person extends Database
{
    public $personID;
    public $email;
    public $firstName;
    public $lastName;
    public $dateCreated;
    
    public function __construct()
    {
        parent::__construct();
        $this->bootstrapTable();
    }
    
    protected function bootstrapTable()
    {
        $tableExists = self::db()->query('SHOW TABLES LIKE "peopleTable"')->fetch_row();
        if (empty($tableExists)) {
            $createResult = self::db()->query(
                "CREATE TABLE peopleTable (
personID INT AUTO_INCREMENT PRIMARY KEY,
personEmail VARCHAR(60) UNIQUE NOT NULL ,
personFirstName VARCHAR(15),
personLastName VARCHAR (30),
dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);");
            if ($createResult) {
                return TRUE;
            }
            die('error creating peopleTable');
        }
    }
    
    public static function validate($data)
    {
        $errors = [];
        if (empty($data['firstName']) || strlen($data['firstName']) > 15) {
            $errors[] = '<p>First Name is required and should be no longer that 15 characters.</p>';
        }
        if (empty($data['lastName']) || strlen($data['lastName']) > 30) {
            $errors[] = '<p>Last Name is required and should be no longer that 30 characters.</p>';
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = '<p>Valid Email is required.</p>';
        }
        
        return array_merge(
            $errors,
            Phone::validate($data),
            Address::validate($data)
        );
    }
    
    public static function findByEmail($email)
    {
        $person = new self();
        $stmnt = self::db()->prepare('SELECT * FROM peopleTable WHERE personEmail = ?');
        $stmnt->bind_param('s', $email);
        $stmnt->execute();
        $personData = $stmnt->get_result()->fetch_assoc();
        if (isset($personData)) {
            $person->personID = $personData['personID'];
            $person->email = $personData['personEmail'];
            $person->firstName = $personData['personFirstName'];
            $person->lastName = $personData['personLastName'];
            $person->dateCreated = $personData['dateCreated'];
            
            return $person;
        }
    }
    
    public static function find($id)
    {
        $person = new self();
        $stmnt = self::db()->prepare('SELECT * FROM peopleTable WHERE personID = ?');
        $stmnt->bind_param('i', $email);
        $stmnt->execute();
        $personData = $stmnt->get_result()->fetch_assoc();
        if (isset($personData)) {
            $person->personID = $personData['personID'];
            $person->email = $personData['personEmail'];
            $person->firstName = $personData['personFirstName'];
            $person->lastName = $personData['personLastName'];
            $person->dateCreated = $personData['dateCreated'];
            
            return $person;
        }
    }
    
    public function all()
    {
        $people = [];
        $selectQuery = "SELECT * FROM peopleTable ORDER BY peopleTable ASC";
        $result = self::db()->query($selectQuery);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $person = new self();
                $person->personID = $row['personID'];
                $person->email = $row['personEmail'];
                $person->firstName = $row['personFirstName'];
                $person->lastName = $row['personLastName'];
                $person->dateCreated = $row['dateCreated'];
                $people[] = $person;
            }
        }
        
        return $people;
    }
    
    public function delete()
    {
        $stmnt = self::db()->prepare('DELETE FROM peopleTable WHERE personID = ?');
        $stmnt->bind_param('i', $this->personID);
        $stmnt->execute();
    }
    
    public function save()
    {
        $firstName = addslashes($this->firstName);
        $lastName = addslashes($this->lastName);
        if (isset($this->personID)) {
            $updateQuery = "UPDATE peopleTable SET personFirstName=?, personLastName=?, personEmail=? WHERE personID=?";
            $stmnt = self::db()->prepare($updateQuery);
            $stmnt->bind_param('sssi', $firstName, $lastName, $this->email, $this->id);
            $stmnt->execute();
        } else {
            $insertQuery = "INSERT INTO peopleTable (personFirstName,personLastName,personEmail) VALUES (?,?,?)";
            $stmnt = self::db()->prepare($insertQuery);
            $stmnt->bind_param('sss', $firstName, $lastName, $this->email);
            if ($stmnt->execute()) {
                $this->personID = self::db()->insert_id;
            }
        }
        //Save Address Info
        $address = Address::findByPersonID($this->personID);
        if (empty($address)) {
            $address = new Address();
        }
        $address->personID = $this->personID;
        $address->address = $this->address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zipCode = $this->zipCode;
        $address->save();
        //Save Phone Number
        $phone = Phone::findByPersonID($this->personID);
        if (empty($phone)) {
            $phone = new Phone();
        }
        $phone->personID = $this->personID;
        $phone->phone = $this->phone;
        $phone->save();
        
        return $this->personID;
    }
}