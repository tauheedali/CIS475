<?php
require_once('autoload.php');

use CIS475\Classes\Contact;

if (isset($_POST)) {
    $errors = Contact::validate($_POST);
    if (empty($errors)) {
        $contact = new Contact();
        $contact->firstName = $_POST['firstName'];
        $contact->lastName = $_POST['lastName'];
        $contact->address = $_POST['address'];
        $contact->city = $_POST['city'];
        $contact->state = $_POST['state'];
        $contact->zipCode = $_POST['zipCode'];
        $contact->phone = $_POST['phone'];
        $contact->email = $_POST['email'];
        $contact->comments = $_POST['comments'];
        $contact->date = date('Y-m-d');
        $contact->save();
        $_SESSION['success'] = '<h3>Thank you!</h3>';
    } else {
        $_SESSION['errors'] = implode('', $errors);
    }
    header("Location: {$baseUrl}php_mysql_form.php");
}
