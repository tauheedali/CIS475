<?php
require_once 'autoload.php';

use CIS475\Classes\Person;
use CIS475\Classes\User;
use CIS475\Classes\Address;
use CIS475\Classes\Phone;
use CIS475\Classes\Contact;
use CIS475\Classes\Database;

function deleteAllTables()
{
    Database::db()->query('SET FOREIGN_KEY_CHECKS = 0;');
    $result = Database::db()->query("SELECT concat('DROP TABLE IF EXISTS`', table_name, '`;')
FROM information_schema.tables
WHERE table_schema = 'alit01'");
    while ($row = $result->fetch_row()) {
        var_dump(current($row));
        Database::db()->query(current($row));
        var_dump(Database::db()->error);
    }
    Database::db()->query('SET FOREIGN_KEY_CHECKS = 1;');
    Database::db()->commit();
}

function createNewTables()
{
    new Person();
    new Address();
    new Phone();
    new User();
    new Contact();
}

echo "<pre>";
$oldUsers = [];
//Check if using old schema
$oldSchema = Database::db()->query("SELECT * FROM `COLUMNS` WHERE TABLE_NAME LIKE 'usersTable' AND COLUMN_NAME LIKE 'userFirstName'");
if ($oldSchema) {
    $q = Database::db()->query('SELECT * FROM usersTable');
    while ($row = $q->fetch_assoc()) {
        $oldUsers[] = $row;
    }
    deleteAllTables();
    //Ensure people and other new tables exists
    echo 'Migrating these users:<br/>';
    var_dump($oldUsers);
    //Save new user data
    foreach ($oldUsers as $oldUser) {
        $user = new User();
        $user->email = $oldUser['userEmail'];
        $user->password = $oldUser['userPass'];
        $user->firstName = $oldUser['userFirstName'];
        $user->lastName = $oldUser['userLastName'];
        $user->address = $oldUser['userAddress'];
        $user->city = $oldUser['userCity'];
        $user->state = $oldUser['userState'];
        $user->zipCode = $oldUser['userZipCode'];
        $user->phone = $oldUser['userPhone'];
        $user->registrationDate = date('Y-m-d h:i:s');
        $user->isAdmin = TRUE;
        $user->save();
    }
}
echo 'User model up to date';



