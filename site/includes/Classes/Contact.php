<?php

namespace CIS475\Classes;

use CIS475\Classes\Database;

class Contact extends Database
{
    public $id;
    public $firstName;
    public $lastName;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    public $phone;
    public $email;
    public $comments;
    private $prefix = 'contact';
    
    public function __construct()
    {
        parent::__construct();
        $this->bootstrapTable();
    }
    
    private function bootstrapTable()
    {
        $tableExists = self::db()->query('SHOW TABLES LIKE "contactsTable"')->fetch_row();
        if (empty($tableExists)) {
            $createResult = self::db()->query(
                "CREATE TABLE contactsTable (
contactID INT AUTO_INCREMENT PRIMARY KEY,
personID INT,
contactComments LONGTEXT,
contactDate DATE,
FOREIGN KEY (personID)
    REFERENCES peopleTable(personID)
    ON DELETE CASCADE
    ON UPDATE CASCADE

);");
            if ($createResult) {
                return TRUE;
            }
            die('error creating contactsTable');
        }
    }
    
    public static function findByEmail()
    {
        return new self;
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
        if (empty($data['address']) || strlen($data['address']) > 30) {
            $errors[] = '<p>Address is required and should be no longer that 30 characters.</p>';
        }
        if (empty($data['city']) || strlen($data['city']) > 30) {
            $errors[] = '<p>City is required and should be no longer that 30 characters.</p>';
        }
        if (empty($data['state']) || !preg_match('/^[A-Z]{2}$/i', $data['state'])) {
            $errors[] = '<p>State is required and should be no longer that 2 characters.</p>';
        }
        if (empty($data['zipCode']) || !preg_match('/^([0-9]{5})(-[0-9]{4})?$/', ($data['zipCode']))) {
            $errors[] = '<p>Zip Code is required and should be no longer that 10 numeric characters.</p>';
        }
        if (empty($data['phone']) || !preg_match('/^\d{10}$/', ($data['phone']))) {
            $errors[] = '<p>Phone number is required and should be no longer that 10 numeric characters.</p>';
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = '<p>Valid Email is required.</p>';
        }
        
        return $errors;
    }
    
    public function save()
    {
        if ($this->id) {
            $stmnt = self::db()->prepare("UPDATE contactsTable SET contactFirstName = :firstName,contactLastName = :lastName,
contactAddress = :address,contactCity = :city,contactState = :state,contactZipCode = :zipCode,contactPhone = :phone,
contactEmail = :email,contactComments = :comments,contactDate = :date WHERE id = :id");
            $stmnt->bind_param(':id', $this->id);
            $stmnt->bind_param(':firstName', addslashes($this->firstName));
            $stmnt->bind_param(':lastName', addslashes($this->lastName));
            $stmnt->bind_param(':address', addslashes($this->address));
            $stmnt->bind_param(':city', addslashes($this->city));
            $stmnt->bind_param(':state', $this->state);
            $stmnt->bind_param(':zipCode', $this->zipCode);
            $stmnt->bind_param(':phone', $this->phone);
            $stmnt->bind_param(':email', $this->email);
            $stmnt->bind_param(':comments', addslashes($this->comments));
            $stmnt->bind_param(':date', $this->date);
            $stmnt->execute();
        } else {
            $insertQuery = "INSERT INTO contactsTable
(contactFirstName,contactLastName,contactAddress,contactCity,contactState,contactZipCode,contactPhone,contactEmail,contactComments,contactDate)
VALUES (?,?,?,?,?,?,?,?,?,?)
";
            $stmnt = self::db()->prepare($insertQuery);
            $stmnt->bind_param('ssssssssss', addslashes($this->firstName),
                addslashes($this->lastName),
                addslashes($this->address),
                addslashes($this->city),
                $this->state,
                $this->zipCode,
                $this->phone,
                $this->email,
                addslashes($this->comments),
                $this->date
            );
            $stmnt->execute();
            $this->id = self::db()->insert_id;
        }
    }
    
}
