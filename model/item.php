<?php

class Item {
    private $itemNo, $name, $description, $reservePrice, $status, $images;
    
    public function __construct($itemNo = NULL, $name = NULL, 
                                $description = NULL, $reservePrice = NULL, 
                                $status = NULL, $primaryThumb = NULL, $images = NULL, $thumbs = NULL) {
        $this->itemNo = $itemNo;
        $this->name = $name;
        $this->description = $description;
        $this->reservePrice = $reservePrice;
        $this->status = $status;
        $this->primaryThumb = $primaryThumb;   
        $this->images = $images;
        $this->thumbs = $thumbs;                             
    }

    // itemNo

    public function getItemNo() {
        return $this->itemNo;
    }
    
    public function setItemNo($value) {
        $this->itemNo = $value;
    }

    // title

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        $this->name = $value;
    }

    // description

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($value) {
        $this->description = $value;
    }

    // reservePrice

    public function getReservePrice() {
        return $this->reservePrice;
    }

    public function setReservePrice($value) {
        $this->reservePrice = $value;
    }

    // status

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($value) {
        $this->status = $value;
    }
    
    // primaryThumb
    
    public function getPrimaryThumb() {
        return $this->primaryThumb;
    }
    
    public function setPrimaryThumb($value) {
        $this->primaryThumb = $value;
    }

    // images

    public function getImages() {
        return $this->images;
    }

    public function setImages($value) {
        $this->images = $value;
    }
    
    // thumbs
    
    public function getThumbs() {
        return $this->thumbs;
    }
    
    public function setThumbs($value) {
        $this->thumbs = $value;
    }
}

?>