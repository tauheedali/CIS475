<?php

namespace CIS475\Classes;
require_once 'autoload.php';

use CIS475\Classes\Database;

class Address extends Database
{
    public $id;
    public $personID;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    
    public function __construct()
    {
        parent::__construct();
        $this->bootstrapTable();
    }
    
    protected function bootstrapTable()
    {
        $tableExists = self::db()->query('SHOW TABLES LIKE "addressesTable"')->fetch_row();
        if (empty($tableExists)) {
            $createResult = self::db()->query(
                "CREATE TABLE addressesTable (
addressID INT AUTO_INCREMENT PRIMARY KEY,
personID INT,
personAddress VARCHAR(60) NOT NULL ,
personCity VARCHAR(15),
personState VARCHAR(2),
personZipCode VARCHAR (10),
INDEX per_ind (personID),
FOREIGN KEY (personID)
    REFERENCES peopleTable(personID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);");
            if ($createResult) {
                return TRUE;
            }
            die('error creating addressesTable');
        }
    }
    
    public static function getStates()
    {
        return array(
            'AL' => 'ALABAMA',
            'AK' => 'ALASKA',
            'AS' => 'AMERICAN SAMOA',
            'AZ' => 'ARIZONA',
            'AR' => 'ARKANSAS',
            'CA' => 'CALIFORNIA',
            'CO' => 'COLORADO',
            'CT' => 'CONNECTICUT',
            'DE' => 'DELAWARE',
            'DC' => 'DISTRICT OF COLUMBIA',
            'FM' => 'FEDERATED STATES OF MICRONESIA',
            'FL' => 'FLORIDA',
            'GA' => 'GEORGIA',
            'GU' => 'GUAM GU',
            'HI' => 'HAWAII',
            'ID' => 'IDAHO',
            'IL' => 'ILLINOIS',
            'IN' => 'INDIANA',
            'IA' => 'IOWA',
            'KS' => 'KANSAS',
            'KY' => 'KENTUCKY',
            'LA' => 'LOUISIANA',
            'ME' => 'MAINE',
            'MH' => 'MARSHALL ISLANDS',
            'MD' => 'MARYLAND',
            'MA' => 'MASSACHUSETTS',
            'MI' => 'MICHIGAN',
            'MN' => 'MINNESOTA',
            'MS' => 'MISSISSIPPI',
            'MO' => 'MISSOURI',
            'MT' => 'MONTANA',
            'NE' => 'NEBRASKA',
            'NV' => 'NEVADA',
            'NH' => 'NEW HAMPSHIRE',
            'NJ' => 'NEW JERSEY',
            'NM' => 'NEW MEXICO',
            'NY' => 'NEW YORK',
            'NC' => 'NORTH CAROLINA',
            'ND' => 'NORTH DAKOTA',
            'MP' => 'NORTHERN MARIANA ISLANDS',
            'OH' => 'OHIO',
            'OK' => 'OKLAHOMA',
            'OR' => 'OREGON',
            'PW' => 'PALAU',
            'PA' => 'PENNSYLVANIA',
            'PR' => 'PUERTO RICO',
            'RI' => 'RHODE ISLAND',
            'SC' => 'SOUTH CAROLINA',
            'SD' => 'SOUTH DAKOTA',
            'TN' => 'TENNESSEE',
            'TX' => 'TEXAS',
            'UT' => 'UTAH',
            'VT' => 'VERMONT',
            'VI' => 'VIRGIN ISLANDS',
            'VA' => 'VIRGINIA',
            'WA' => 'WASHINGTON',
            'WV' => 'WEST VIRGINIA',
            'WI' => 'WISCONSIN',
            'WY' => 'WYOMING',
            'AE' => 'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
            'AA' => 'ARMED FORCES AMERICA (EXCEPT CANADA)',
            'AP' => 'ARMED FORCES PACIFIC'
        );
    }
    
    public static function validate($data)
    {
        $errors = [];
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
        
        return $errors;
    }
    
    public function save()
    {
        $city = addslashes($this->city);
        $address = addslashes($this->address);
        if (isset($this->id)) {
            $updateQuery = "UPDATE addressesTable SET personID=?, personAddress=?, personCity=?, personState=?, personZipCode=? WHERE addressID=?";
            $stmnt = self::db()->prepare($updateQuery);
            $stmnt->bind_param('issssi', $this->personID, $address, $city, $this->state, $this->zipCode, $this->id);
            $stmnt->execute();
        } else {
            $insertQuery = "INSERT INTO addressesTable (personID,personAddress,personCity,personState,personZipCode) VALUES (?,?,?,?,?)";
            $stmnt = self::db()->prepare($insertQuery);
            echo self::db()->error;
            $stmnt->bind_param('issss', $this->personID, $address, $city, $this->state, $this->zipCode);
            if ($stmnt->execute()) {
                $this->id = self::db()->insert_id;
            }
        }
    
    }
    public static function findByPersonID($personID){
        $address = new self();
        $stmnt = self::db()->prepare('SELECT * FROM addressesTable WHERE personID = ?');
        $stmnt->bind_param('i', $personID);
        $stmnt->execute();
        $addressData = $stmnt->get_result()->fetch_assoc();
        if (isset($addressData)) {
            $address->id = $addressData['addressID'];
            $address->personID = $addressData['personID'];
            $address->address = $addressData['personAddress'];
            $address->city = $addressData['personCity'];
            $address->state = $addressData['personState'];
            $address->zipCode = $addressData['personZipCode'];
        
            return $address;
        }
    }
}