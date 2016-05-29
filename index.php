<?php
require_once('util/main.php');
require_once('model/announcement.php');
require_once('model/announcements_db.php');
require_once('model/database.php');

$announcements = getAnnouncements(true); // Get last 3
include('view/home/home_view.php');

?>