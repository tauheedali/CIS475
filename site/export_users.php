<?php
require_once 'autoload.php';

use CIS475\Classes\CSVWriter;
use CIS475\Classes\User;
$time = date('Y-m-d_h:iA');
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=users_$time.csv");
$users = User::all();
$usersCSV = new CSVWriter();
foreach ($users as $index => $user) {
    if ($index == 0) {
        $header = array_keys(get_object_vars($user));
        $usersCSV->addRow($header);
    }
    $usersCSV->addRow(get_object_vars($user));
}
