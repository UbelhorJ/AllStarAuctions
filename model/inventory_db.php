<?php

// turn result info into item object
function createItem($result) {
    $item = new item($result['itemNo'],
                     $result['name'],
                     $result['description'],
                     $result['reservePrice'],
                     $result['status'],
                     $result['primaryThumb']);
    return $item;
}

// send each item result to become object
function buildItemsArray($results) {
    $inventoryList = array();
    
    foreach($results as $result) {
        $item = createItem($result);
        $inventoryList[] = $item;
    }
    
    return $inventoryList;
}

// find the number of rows for the selected options
function getInventoryRowCount($status, $order_by, $direction) {
    global $db;

    $query = 'SELECT COUNT(*) 
              FROM inventory
              WHERE ';
    
    // build WHERE clause
    $status_count = 0;

    foreach ($status as $key=>$value) {
        if ($value === true) {
            if ($status_count > 0) $query .= ' OR ';  
            $query .= 'status = ' . '\'' . $key . '\'';
            $status_count++;
        }
    }

    
    // add ORDER BY clause
    $query .= ' ORDER BY ' . $order_by;
    
    // add direction
    $query .= ' ' . $direction;
        
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        
        $count = $result[0];
        
        return $count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('..\..\view\errors\error.php');
    }
}

// get inventory based on status options
function getInventory($status, $order_by, $direction, $limit) {
    global $db;

    $query = 'SELECT * FROM inventory
              WHERE ';
    
    // build WHERE clause
    $status_count = 0;

    foreach ($status as $key=>$value) {
        if ($value === true) {
            if ($status_count > 0) $query .= ' OR ';  
            $query .= 'status = ' . '\'' . $key . '\'';
            $status_count++;
        }
    }

    
    // add ORDER BY clause
    $query .= ' ORDER BY ' . $order_by;
    
    // add direction
    $query .= ' ' . $direction;
    
    // add LIMIT
    if ($limit != false) $query .= ' LIMIT ' . $limit['offset'] . ', ' . $limit['itemsPerPage'];
    
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        
        $inventoryList = buildItemsArray($results);
        
        return $inventoryList;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('..\..\view\errors\error.php');
    }
}

// get a single item
function getItem($itemNo) {
    global $db;
    
    $query = 'SELECT * FROM inventory
             WHERE itemNo = :itemNo;';

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':itemNo', $itemNo);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        
        $item = createItem($result);
        
        return $item;
    } catch (PDOException $e) {
            $error_message = $e->getMessage();
            include('..\..\view\errors\error.php');
    }

}

// check to see if item exists
function itemExists($itemNo) {
    global $db;
    
    $query = 'SELECT 1 FROM inventory 
             WHERE itemNo = :itemNo
             LIMIT 1;';
             
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':itemNo', $itemNo);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        
        return $result['1'] == 1 ? true : false;
    } catch (PDOException $e) {
            $error_message = $e->getMessage();
            include('..\..\view\errors\error.php');
    }
}

// add new item to database and return new item number
function saveNewItem($item) {
    global $db_admin;
    
    $query = "INSERT INTO inventory
                (name, description, reservePrice, status)
            VALUES
                (:name, :description, :reservePrice, :status);";
    
    try {
        $statement = $db_admin->prepare($query);
        $statement->bindValue(':name', $item->getName());
        $statement->bindValue(':description', $item->getDescription());
        $statement->bindValue(':reservePrice', $item->getReservePrice());
        $statement->bindValue(':status', $item->getStatus());
        $statement->execute();
        $itemNo = $db_admin->lastInsertID();
        $statement->closeCursor();
        return $itemNo;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../view/errors/error.php');
    }     
}

function updateItem($item) {
    global $db_admin;
    
    $query = "UPDATE inventory
              SET name = :name, description = :description, reservePrice = :reservePrice, status = :status, primaryThumb = :primaryThumb
              WHERE itemNo = :itemNo;";
    
    try {
        $statement = $db_admin->prepare($query);
        $statement->bindValue(':name', $item->getName());
        $statement->bindValue(':description', $item->getDescription());
        $statement->bindValue(':reservePrice', $item->getReservePrice());
        $statement->bindValue(':status', $item->getStatus());
        $statement->bindvalue(':primaryThumb', $item->getPrimaryThumb());
        $statement->bindValue(':itemNo', $item->getItemNo());
        $statement->execute();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../view/errors/error.php');
    }     
}

function deleteItem($itemNo) {
    global $db_admin;
    
    $query ="DELETE FROM inventory
             WHERE itemNo = :itemNo";

    try {
        $statement = $db_admin->prepare($query);
        $statement->bindValue(':itemNo', $itemNo);
        $statement->execute();
    } catch (PDOException $e) {
            $error_message = $e->getMessage();
            include('..\..\view\errors\error.php');
    }
}     


?>   