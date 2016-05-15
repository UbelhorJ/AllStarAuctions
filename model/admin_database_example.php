<?php
// real database, user name, and password hidden from GitHub
// remove "_example" from file name


$dsn = 'mysql:host=localhost;dbname=databaseName';
$username = 'asdf';
$password = 'password123';
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $db_admin = new PDO($dsn, $username, $password, $options);    
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include 'view/errors/error.php';
    exit;
}