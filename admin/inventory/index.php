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
    header('Location: ' . $app_path . 'admin?action=login');
}

// perform specified action
switch($action) {
    case 'show_inventory_home':
        // get selected item statuses
        $status = array();
        $status['d'] = isset($_GET['display']) ? true : false;
        $status['h'] = isset($_GET['hidden']) ? true : false;
        $status['s'] = isset($_GET['sold']) ? true : false;
        // check display items if none selected 
        if ($status['h'] === false && $status['s'] === false) {
            $status['d'] = true;
        }
        
        // get order by options
        if (isset($_GET['order_by'])) {
            $order_by = $_GET['order_by'];
        } else {
            $order_by = 'itemNo';
        }
        
        // get direction for order by
        if (isset($_GET['direction'])) {
            $direction = $_GET['direction'];
        } else {
            $direction = 'DESC';
        }
        
        // setup pagination and limit
        $limit = array('itemsPerPage' => 15);
        $itemCount =  getInventoryRowCount($status, $order_by, $direction);
        $totalPages = ceil($itemCount / $limit['itemsPerPage']);
        
        isset($_GET['pageNo']) ? $pageNo = $_GET['pageNo'] : $pageNo = 1;
        if ($pageNo < 1) $pageNo = 1;
        if ($pageNo > $totalPages) $pageNo = $totalPages;
        
        $limit['offset'] = ($pageNo - 1) * $limit['itemsPerPage'];
                                    
        // create list of item objects
        $inventoryList = getInventory($status, $order_by, $direction, $limit);
        
        // add images to item objects
        foreach ($inventoryList as $item) {
            $itemNo = $item->getItemNo();
            $images_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'original';
            $thumbs_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'thumbs';
            $images = scandir($images_dir);
            $thumbs = scandir($thumbs_dir);
            array_shift($images); array_shift($images); array_shift($thumbs); array_shift($thumbs); // remove stupid . and ..
            $item->setImages($images);
            $item->setThumbs($thumbs);
            
            // if no primary thumbnail image set, choose first thumbnail
            if ($item->getPrimaryThumb() == NULL) {
                $item->setPrimaryThumb($thumbs[0]);
            }
        }
                
        include('../../view/admin/admin_inventory_view.php');
        break;
    case 'new_item':
        // collect info for database
        $item = new item();
        $item->setName($_POST['name']);
        $item->setDescription($_POST['description']);
        $item->setReservePrice($_POST['reserve']);
        $item->setStatus($_POST['status']);
        
        // save item data to database and return new item number
        $itemNo = saveNewItem($item);
        
        // upload images to images/inventory/$itemNo
        $image_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo;
        $original_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'original';
        $thumb_dir = realpath('../../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'thumbs';
        mkdir($image_dir);
        mkdir($original_dir);
        mkdir($thumb_dir);
        
        $imageCount = count($_FILES['uploaded_images']['name']);
        
        for ($i = 0; $i < $imageCount; $i++) {
            $tempLocation = $_FILES['uploaded_images']['tmp_name'][$i];
            $fileName = $_FILES['uploaded_images']['name'][$i];
            $saveLocation = $original_dir . DIRECTORY_SEPARATOR . $fileName;
           
            // upload user images in original size
            move_uploaded_file($tempLocation, $saveLocation);
            
            // create copies with max widths of 125pxpx
            process_thumb($fileName, $original_dir, $thumb_dir);
        }       
               
        // refresh inventory management page
        header('Location: .?action=show_inventory_home');
        break;
}

?>