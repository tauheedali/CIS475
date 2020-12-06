<?php

namespace CIS475;
require_once('includes/config.php');
require_once('includes/vars.php');
require_once('includes/functions.php');
spl_autoload_register(function ($className) {
    $classPath = str_replace("\\", "/", $className) . '.php';
    $classPath = str_replace(__NAMESPACE__, 'includes', $classPath);
    if (is_file($classPath)) {
        require_once $classPath;
    }
});