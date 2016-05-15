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
    $action = 'show_announcements_home';
}


// If the user isn't logged in, redirect to login page
if (!isset($_SESSION['is_valid_admin'])) {
    header('Location: ' . $app_path . 'admin?action=login.php');
}

// perform specified action
switch($action) {
    case 'show_announcements_home';
        include('../view/admin/admin_announcements_view.php');
}

?>