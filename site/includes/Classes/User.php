<?php

namespace CIS475\Classes;
require_once 'autoload.php';

use CIS475\Classes\Person;

class User extends Person
{
    public $id;
    public $personID;
    public $email;
    public $password;
    public $firstName;
    public $lastName;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    public $phone;
    public $lastLogin;
    public $registrationDate;
    public $isAdmin = FALSE;
    
    public function __construct()
    {
        parent::__construct();
        $this->bootstrapTable();
    }
    
    protected function bootstrapTable()
    {
        $tableExists = self::db()->query('SHOW TABLES LIKE "usersTable"')->fetch_row();
        if (empty($tableExists)) {
            $createResult = self::db()->query(
                "CREATE TABLE usersTable (
userID INT AUTO_INCREMENT PRIMARY KEY,
personID INT,
userEmail VARCHAR(60) UNIQUE NOT NULL ,
userPass VARCHAR (50) NOT NULL ,
lastLogin TIMESTAMP NULL,
registrationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
isAdmin TINYINT NOT NULL,
FOREIGN KEY (personID)
    REFERENCES peopleTable(personID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);");
            if ($createResult) {
                return TRUE;
            }
            die('error creating usersTable');
        }
    }
    
    public static function validate($data, $createMode = TRUE)
    {
        $errors = parent::validate($data);
        if ($data['password'] != $data['password_confirmation']) {
            $errors[] = '<p>Password must match</p>';
        }
        if ($createMode) {
            if (empty($data['password'])) {
                $errors[] = '<p>Password is required</p>';
            }
            if (!empty(self::findByEmail($data['email']))) {
                $errors[] = '<p>Email is already in use. Try resetting your password.</p>';
            }
        }
        
        return $errors;
    }
    
    public static function findByEmail($email)
    {
        $userQuery = "SELECT *
FROM usersTable
JOIN peopleTable ON usersTable.personID = peopleTable.personID
LEFT JOIN addressesTable ON peopleTable.personID = addressesTable.personID
LEFT JOIN phonesTable ON peopleTable.personID = phonesTable.personID
WHERE userEmail = ?";
        $user = new self();
        $stmnt = self::db()->prepare($userQuery);
        $stmnt->bind_param('s', $email);
        $stmnt->execute();
        $userData = $stmnt->get_result()
                          ->fetch_assoc();
        if (isset($userData)) {
            $user->id = $userData['userID'];
            $user->personID = $userData['personID'];
            $user->email = $userData['userEmail'];
            $user->password = $userData['userPass'];
            $user->firstName = $userData['personFirstName'];
            $user->lastName = $userData['personLastName'];
            $user->address = $userData['personAddress'];
            $user->city = $userData['personCity'];
            $user->state = $userData['personState'];
            $user->zipCode = $userData['personZipCode'];
            $user->phone = $userData['personPhone'];
            $user->isAdmin = boolval($userData['isAdmin']);
            
            return $user;
        }
    }
    
    public static function find($id)
    {
        $userQuery = "SELECT *
FROM usersTable
JOIN peopleTable ON usersTable.personID = peopleTable.personID
LEFT JOIN addressesTable ON peopleTable.personID = addressesTable.personID
LEFT JOIN phonesTable ON peopleTable.personID = phonesTable.personID
WHERE userID = ?";
        $user = new self();
        $stmnt = self::db()->prepare($userQuery);
        $stmnt->bind_param('i', $id);
        $stmnt->execute();
        $userData = $stmnt->get_result()->fetch_assoc();
        if (isset($userData)) {
            $user->id = $userData['userID'];
            $user->personID = $userData['personID'];
            $user->email = $userData['userEmail'];
            $user->password = $userData['userPass'];
            $user->firstName = $userData['personFirstName'];
            $user->lastName = $userData['personLastName'];
            $user->address = $userData['personAddress'];
            $user->city = $userData['personCity'];
            $user->state = $userData['personState'];
            $user->zipCode = $userData['personZipCode'];
            $user->phone = $userData['personPhone'];
            $user->isAdmin = boolval($userData['isAdmin']);
            
            return $user;
        }
    }
    
    public function all()
    {
        $users = [];
        $selectQuery = "SELECT * FROM usersTable
JOIN peopleTable ON usersTable.personID = peopleTable.personID
JOIN phonesTable ON usersTable.personID = phonesTable.personID
JOIN addressesTable ON usersTable.personID = addressesTable.personID ORDER BY userID ASC";
        $result = self::db()->query($selectQuery);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $user = new self();
                $user->id = $row['userID'];
                $user->personID = $row['personID'];
                $user->email = $row['userEmail'];
                $user->password = $row['userPass'];
                $user->firstName = $row['personFirstName'];
                $user->lastName = $row['personLastName'];
                $user->address = $row['personAddress'];
                $user->city = $row['personCity'];
                $user->state = $row['personState'];
                $user->zipCode = $row['personZipCode'];
                $user->phone = $row['personPhone'];
                $user->registrationDate = $row['registrationDate'];
                $user->lastLogin = $row['lastLogin'];
                $user->isAdmin = $row['isAdmin'];
                $users[] = $user;
            }
        }
        
        return $users;
    }
    
    public function delete()
    {
        parent::delete();
    }
    
    public function save()
    {
        //Save the Person information
        $this->personID = parent::save();
        //Save user information
        if (isset($this->id)) {
            $updateQuery = "UPDATE usersTable SET personID=?, userEmail=?, userPass=?, lastLogin=?, registrationDate=?, isAdmin=? WHERE userId=?";
            $stmnt = self::db()->prepare($updateQuery);
            $stmnt->bind_param('issssii',
                $this->personID,
                $this->email,
                $this->password,
                $this->lastLogin,
                $this->registrationDate,
                $this->isAdmin,
                $this->id
            );
        } else {
            $insertQuery = "INSERT INTO usersTable (personID,userEmail,userPass,lastLogin,registrationDate,isAdmin) VALUES (?,?,?,?,?,?)";
            $stmnt = self::db()->prepare($insertQuery);
            $stmnt->bind_param('issssi',
                $this->personID,
                $this->email,
                $this->password,
                $this->lastLogin,
                $this->registrationDate,
                $this->isAdmin
            );
            if ($stmnt->execute()) {
                $this->id = self::db()->insert_id;
            }
        }
    }
}