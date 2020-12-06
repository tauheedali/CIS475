<?php

namespace CIS475\Services;

use \DateTime;
use \DateInterval;
use CIS475\Classes\User;

class Auth
{
    
    public static function verifyLogin()
    {
        if (isset($_SESSION['timestamp'])) {
            $sessionLength = new DateInterval('PT2H');
            $sessionStart = new DateTime();
            $now = new DateTime();
            $sessionStart = $sessionStart->setTimestamp($_SESSION['timestamp']);
            $expiration = $sessionStart->add($sessionLength);
            if ($now <= $expiration) {
                //Refresh session
                $_SESSION['timestamp'] = $now->getTimestamp();
                
                return TRUE;
            };
        }
        
        return FALSE;
    }
    
    public static function validate($data)
    {
        $errors = [];
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = '<p>Valid Email is required.</p>';
        }
        if (empty($data['password'])) {
            $errors[] = '<p>Password is required and must match</p>';
        }
        
        return $errors;
    }
    
    public static function logout()
    {
        session_destroy();
    }
    
    public static function login($email, $password)
    {
        global $debug;
        $user = User::findByEmail($email);
        $status = new \stdClass();
        $status->error = TRUE;
        $status->message = 'Username/password combination not found';
        if (!empty($user) && $user->password === sha1($password)) {
            $_SESSION['user_email'] = $email;
            $_SESSION['user_password'] = $password;
            $_SESSION['isAdmin'] = $user->isAdmin;
            $now = new DateTime();
            $_SESSION['timestamp'] = $now->getTimestamp();
            if ($debug) {
                print_r($_SESSION);
            }
            $status->error = FALSE;
            $status->message = "You are logged in";
            if ($user->isAdmin) {
                $status->message .= " as an Admin";
            }
            $user->lastLogin = date('Y-m-d h:i:s');
            $user->save();
        }
        
        return $status;
    }
}