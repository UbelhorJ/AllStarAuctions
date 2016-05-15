<?php

// turn sent data into announcement object
function createAnnouncement($result) {
    $announcement = new announcement($result['id'],
                                     $result['title'],
                                     $result['body'],
                                     $result['dateTime']);
    return $announcement;
}

// send each announcement to become object 
function buildAnnouncementArray($results) {
    $announcementList = array();
    
    foreach($results as $result) {
        $announcement = createAnnouncement($result);
        $announcementList[] = $announcement;
    }
    
    return $announcementList;
}

// return all announcements from database
function getAnnouncements() {
    global $db;
    
    $query = "SELECT * FROM announcements
              ORDER BY id DESC";
    
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        
        $announcementList = buildAnnouncementArray($results);
        
        return $announcementList;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('..\..\view\errors\error.php');
    }
}

function addAnnouncement($announcement) {
    global $db_admin;
    
    $query = 'INSERT INTO announcements
                  (title, body, dateTime)
              VALUES
                  (:title, :body, NOW());';

    try {
        $statement = $db_admin->prepare($query);
        $statement->bindValue(':title', $announcement->getTitle());
        $statement->bindValue(':body', $announcement->getBody());
        $statement->execute();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('..\..\view\errors\error.php');
    }
}

function deleteAnnouncement($id) {
    global $db_admin;
    
    $query = 'DELETE FROM announcements
              WHERE id = :id;';
    
        try {
        $statement = $db_admin->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('..\..\view\errors\error.php');
    }
}

?>