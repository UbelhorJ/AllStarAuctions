<?php
function is_valid_admin_login($user_name, $user_password) {
    global $db_admin;  
    $user_password = sha1($user_name . $user_password);
    $valid = false;
    
    $query = 'SELECT adminID
              FROM administrators
              WHERE userName = :user_name AND password = :password';
    
    $statement = $db_admin->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':password', $user_password);
    $statement->execute();
    $valid = ($statement->rowCount() == 1);
    $statement->closeCursor();
    return $valid;
}

?>