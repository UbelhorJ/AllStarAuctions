<?php
// start session and include necessary functions
session_start();
require_once('../../util/main.php');
require_once('../../util/images.php');
require_once('../../model/item.php');
require_once('../../model/inventory_db.php');
require_once('../../model/database.php');
require_once('../../model/admin_database.php');

// get action or set default
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'show_inventory_home';
}


// If the user isn't logged in, redirect to login page
if (!isset($_SESSION['is_valid_admin'])) {
    header('Location: ' . $app_path . 'admin?action=login.php');
}

// perform specified action
switch($action) {
    case 'show_inventory_home';
        // create list of item objects
        $inventoryList = getInventory();
        
        // add images to item objects
        foreach ($inventoryList as $item) {
            $itemNo = $item->getItemNo();
            $image_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo;
            $images = scandir($image_dir);
            array_shift($images); array_shift($images); // remove stupid . and ..
            $item->setImages($images);
            
            // if no primary thumbnail image set, choose first thumbnail
            if ($item->getPrimaryThumb() == NULL) {
                $item->setPrimaryThumb($images[2]);
            }
        }
                
        include('../../view/admin/admin_inventory_view.php');
        break;
    case 'new_item':
        // collect item data for database
        $item = new item();
        $item->setName($_POST['name']);
        $item->setDescription($_POST['description']);
        $item->setReservePrice($_POST['reserve']);
        $item->setStatus($_POST['status']);
        
        // save item data to database and return new item number
        $itemNo = saveNewItem($item);
        
        // upload images to images/inventory/$itemNo
        $image_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo;
        mkdir($image_dir);
        $imageCount = count($_FILES['uploaded_images']['name']);
        
        for ($i = 0; $i < $imageCount; $i++) {
            $tempLocation = $_FILES['uploaded_images']['tmp_name'][$i];
            $fileName = $_FILES['uploaded_images']['name'][$i];
            $saveLocation = $image_dir . DIRECTORY_SEPARATOR . $fileName;
           
            // upload user images in original size
            move_uploaded_file($tempLocation, $saveLocation);
            
            // create copies with max widths of 500px and 150px
            process_image($fileName, $image_dir);
        }       
               
        // refresh inventory management page
        header('Location: .?action=show_inventory_home');
        break;
}

?>