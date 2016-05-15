<?php
// start session and include necessary functions
session_start();
require_once('../util/main.php');
require_once('../model/admin_database.php');
require_once('../model/admin_db.php');

// get action or set default
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'show_admin_home';
}

// If the user isn't logged in, redirect to login page
if (!isset($_SESSION['is_valid_admin'])) {
    $action = 'login';
}

// perform specified action
switch($action) {
    case 'login':
        if (isset($_POST['user_name'])) {
            $user_name = $_POST['user_name'];    
        }
        
        if (isset($_POST['user_password'])) {
            $user_password = $_POST['user_password'];            
        }

        if (is_valid_admin_login($user_name, $user_password)) {
            $_SESSION['is_valid_admin'] = true;
            include('../view/admin/admin_home_view.php');
        } else {
            $login_message = 'Incorrect user name or password.';
            include('../view/admin/login.php');
        }
        break;
    case 'logout':
        $_SESSION = array();
        session_destroy();
        $login_message = 'You have been logged out.';
        include('../view/admin/login.php');
        break;
    case 'show_admin_home':
        include('../view/admin/admin_home_view.php');
        break;
}

?>