<?php

function process_image($fileName, $image_dir) {
    // split file name into name and extension.
    $image_dir = $image_dir . DIRECTORY_SEPARATOR;
    $i = strrpos($fileName, '.');
    $imageName = substr($fileName, 0, $i);
    $ext = substr($fileName, $i);
    
    // get path to full size image and set paths for new images
    $old_image_path = $image_dir . $fileName;
    $image_path_slideshow = $image_dir . $imageName . '_slide' . $ext;
    $image_path_thumbnail = $image_dir . $imageName . '_thumb' . $ext;
    
    // resize the image and save
    resize_image($old_image_path, $image_path_slideshow, '500', '1000');
    resize_image($old_image_path, $image_path_thumbnail, '150', '150');
}

function resize_image($old_image_path, $new_image_path, $max_width, $max_height) {
    // get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // load full size image and get its height and width
    $old_image = imagecreatefromjpeg($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
    
    // calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
    
    // if image is larger than max, create a new image
    if ($width_ratio > 1 || $height_ratio > 1) {
        
        // calculate height and width for new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);
        
        // Create new image and then save it
        $new_image = imagecreatetruecolor($new_width, $new_height); // create empty image in memory
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, // copy old image to new image
                           $new_width, $new_height, $old_width, $old_height);
        imagejpeg($new_image, $new_image_path); // write new image to file
        
        // remove image from memory
        imagedestroy($new_image);
    } else {
        // image already under max size. Make copy with new name.
        imagejpeg($old_image, $new_image_path);
    }
    // remove old image from memory
    imagedestroy($old_image);
}

?>