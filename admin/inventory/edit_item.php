<?php
// start session and include necessary functions
session_start();

require_once('../../util/main.php');
require_once('../../util/images.php');
require_once('../../model/item.php');
require_once('../../model/inventory_db.php');
require_once('../../model/database.php');
require_once('../../model/admin_database.php');

// If the user isn't logged in, redirect to login page
if (!isset($_SESSION['is_valid_admin'])) {
    header('Location: ' . $app_path . 'admin?action=login');
}

// get action or set default
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'edit_item';
}

switch ($action) {
    case 'edit_item':
        // create item object
        if (isset($_GET['itemNo'])) {
            $itemNo = $_GET['itemNo'];
        } else {
            header('Location: ' . $app_path . 'admin/inventory');
        }
        
        // create Item
        $item = getItem($itemNo);
        
        // get images
        $images_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'original';
        $thumbs_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'thumbs';
        $images = scandir($images_dir);
        $thumbs = scandir($thumbs_dir);
        array_shift($images); array_shift($images); array_shift($thumbs); array_shift($thumbs); // remove stupid . and ..
        $item->setImages($images);
        $item->setThumbs($thumbs);
        
        include('../../view/admin/admin_edit_item_view.php');       
        break;
    case 'save_changes':
        // collect info for database
        $item = new item();
        $item->setItemNo($_POST['itemNo']);
        $item->setName($_POST['name']);
        $item->setDescription($_POST['description']);
        $item->setReservePrice($_POST['reserve']);
        $item->setStatus($_POST['status']);
        $item->setPrimaryThumb($_POST['primary_thumb']);
        
        // save info to database
        updateItem($item);
        
        // set image directories
        $itemNo = $item->getItemNo();
        $image_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo;
        $original_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'original';
        $thumb_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'thumbs';
        
        // upload new images
            $imageCount = count($_FILES['uploaded_images']['name']);
            for ($i = 0; $i < $imageCount; $i++) {
                if ($_FILES['uploaded_images']['error'][$i] != 4) {
                    $tempLocation = $_FILES['uploaded_images']['tmp_name'][$i];
                    $fileName = $_FILES['uploaded_images']['name'][$i];
                    $saveLocation = $original_dir . DIRECTORY_SEPARATOR . $fileName;
                
                    // upload user images in original size
                    move_uploaded_file($tempLocation, $saveLocation);
                    
                    // create copies with max widths of 125pxpx
                    process_thumb($fileName, $original_dir, $thumb_dir);
                }
            }

            
        // delete marked images
        if (isset($_POST['delete'])) {
            $images_to_delete = $_POST['delete'];
            
            foreach ($images_to_delete as $image) {
                $i = strrpos($image, '.');
                $image_name = substr($image, 0, $i);
                $ext = substr($image, $i);
                
                $original_path = $original_dir . DIRECTORY_SEPARATOR . $image;
                $thumb_path =  $thumb_dir . DIRECTORY_SEPARATOR . $image_name . '_thumb' . $ext;
                
                 if (is_file($original_path)) {
                    unlink($original_path); 
                 }
                
                 if (is_file($thumb_path)) {
                    unlink($thumb_path); 
                }  
            }   
        }
        
        header('Location: ' . $app_path . 'admin/inventory');
        break;
    case 'delete_item':
        $itemNo = $_GET['itemNo'];

        // get images
        $item_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo;
        $images_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'original';
        $thumbs_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'thumbs';
        $images = scandir($images_dir);
        $thumbs = scandir($thumbs_dir);
        array_shift($images); array_shift($images); array_shift($thumbs); array_shift($thumbs); // remove stupid . and ..
        
        // delete the images
        foreach ($images as $image) {
            $image_path = $images_dir . DIRECTORY_SEPARATOR . $image;
            if (is_file($image_path)) {
                unlink($image_path);
            } 
        }
        
        foreach ($thumbs as $thumb) {
            $thumb_path = $thumbs_dir . DIRECTORY_SEPARATOR . $thumb;
            if (is_file($thumb_path)) {
                unlink($thumb_path);
            } 
        }
        
        // delete the directories
        rmdir($images_dir);
        rmdir($thumbs_dir);
        rmdir($item_dir);
        
        deleteItem($itemNo);
        
        header('Location: ' . $app_path . 'admin/inventory');
        break;
}

?>