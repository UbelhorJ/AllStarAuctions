<?php
// start session and include necessary functions
require_once('../util/main.php');
require_once('../util/images.php');
require_once('../model/item.php');
require_once('../model/inventory_db.php');
require_once('../model/database.php');

// get action or set default
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'show_inventory';
}

switch ($action) {
    case 'show_inventory':
        // get all items with a "display" status
        $status = array('d' => true, 'h' => false, 's' => false);
        $order_by = 'itemNo';
        $direction = 'DESC';
        
        $inventoryList = getInventory($status, $order_by, $direction);
        
        // loal thumbnail images and set primary
        foreach ($inventoryList as $item) {
            $itemNo = $item->getItemNo();
            $thumbs_dir = realpath('../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'thumbs';
            $thumbs = scandir($thumbs_dir);
            array_shift($thumbs); array_shift($thumbs); // remove stupid . and ..
            $item->setThumbs($thumbs);
            
            // if no primary thumbnail image set, choose first thumbnail
            if ($item->getPrimaryThumb() == NULL) {
                $item->setPrimaryThumb($thumbs[0]);
            }
        }
        
        include('../view/inventory/inventory_view.php');
        break;
    case 'view_item':
        if (isset($_GET['itemNo'])) {
            $itemNo = $_GET['itemNo'];
        } else {
            header('Location: .?action=show_inventory');
        }
        
        // create Item
        $item = getItem($itemNo);
        
        // load  images for slideshow
        $images_dir = realpath('../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'original';
        $thumbs_dir = realpath('../images/inventory') . DIRECTORY_SEPARATOR . $itemNo . DIRECTORY_SEPARATOR . 'thumbs';
        $images = scandir($images_dir);
        $thumbs = scandir($thumbs_dir);
        array_shift($images); array_shift($images); array_shift($thumbs); array_shift($thumbs); // remove stupid . and ..
        $item->setImages($images);
        $item->setThumbs($thumbs);
        
        include('../view/inventory/item_view.php');    
        break;
}

?>