<?php
    include_once('../includes/database.php');

    function getUsers(){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User');
        $stmt->execute();
        return $stmt->fetchAll(); 
    }

    function addUser($username, $password, $email){
        $db = Database::db();
        $stmt = $db->prepare('INSERT INTO User VALUES(?, ?, ?, ?)');
        $stmt->execute(array(null, $username, $password, $email));
    }

    function userExist($username){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User WHERE username = ?');
        $stmt->execute(array($username));
        return $stmt->fetch() ? true : false; 
    }

    function getUser($username){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User WHERE username = ?');
        $stmt->execute(array($username));
        return $stmt->fetch();
    } 
    
    function updateUsername($user_id, $newUsername){
        $db = Database::db();
        $stmt = $db->prepare('UPDATE User SET username = ? WHERE user_id = ?');
        $stmt->execute(array($newUsername, $user_id));
        return $stmt->fetch() ? true : false; 
    }

    function updateEmail($user_id, $newEmail){
        $db = Database::db();
        $stmt = $db->prepare('UPDATE User SET email = ? WHERE user_id = ?');
        $stmt->execute(array($newEmail, $user_id));
        return $stmt->fetch() ? true : false; 
    }

    function updatePassword($user_id, $newPassword){
        $db = Database::db();
        $stmt = $db->prepare('UPDATE User SET password = ? WHERE user_id = ?');
        $stmt->execute(array($newPassword, $user_id));
        return $stmt->fetch() ? true : false; 
    }

    function checkUserPassword($username, $password){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User WHERE username = ? AND password = ?');
        $stmt->execute(array($username, $password));
        return $stmt->fetch() ? true : false; 
    }
?>