<?php

class Announcement {
    private $id, $title, $body, $dateTime;
    
    public function __construct($id = NULL, $title = NULL, $body = NULL, $dateTime = NULL) {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->dateTime = $dateTime;
    }
    
    // id
    
    public function getID() {
        return $this->id;
    }
    
    // title
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($value) {
        $this->title = $value;
    }
    
    // body
    
    public function getBody() {
        return $this->body;
    }
    
    public function setBody($value) {
        $this->body = $value;
    }
    
    // dateTime
    
    public function getDateTime() {
        return $this->dateTime;
    }
    
    public function setDateTime($value) {
        $this->dateTime = $value;
    }
}

?>