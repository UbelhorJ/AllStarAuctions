<?php
// start session and include necessary functions
session_start();
require_once('../../util/main.php');
require_once('../../model/announcement.php');
require_once('../../model/announcements_db.php');
require_once('../../model/database.php');
require_once('../../model/admin_database.php');
//require_once('../../model/admin_db.php');

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
    header('Location: ' . $app_path . 'admin?action=login');
}

// perform specified action
switch($action) {
    case 'show_announcements_home';
        $announcements = getAnnouncements();
        include('../../view/admin/admin_announcements_view.php');
        break;
    case 'add_announcement':
        $announcement = new announcement();
        $announcement->setTitle($_POST['announcementTitle']);
        $announcement->setBody($_POST['announcementBody']);
        addAnnouncement($announcement);
        header('Location: .');
        break;
    case 'delete_announcement':
        $id = $_POST['announcementToDelete'];
        deleteAnnouncement($id);
        header('Location: .');
        break;
}

?>