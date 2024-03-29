<?php
    include_once('../includes/database.php');

    function getUsers(){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User');
        $stmt->execute();
        return $stmt->fetchAll(); 
    }

    function addUser($username, $password, $email){
        $options = ['cost' => 12];
        $db = Database::db();
        $stmt = $db->prepare('INSERT INTO User VALUES(?, ?, ?, ?)');
        return intval($db->lastInsertId());
        $stmt->execute(array(null, $username, password_hash($password, PASSWORD_DEFAULT, $options), $email));
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
    function getUserById($user_id){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User WHERE user_id = ?');
        $stmt->execute(array($user_id));
        return $stmt->fetch();
    }

    function updateUser($user_id, $newUsername, $newPassword, $newEmail){
        $db = Database::db();
        $stmt = $db->prepare('UPDATE User SET username = ?, email = ?, password = ? WHERE user_id = ?');
        return $stmt->execute(array($newUsername, $newEmail, $newPassword, $user_id));
    }

    function checkUserPassword($username, $password){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User WHERE username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if ($user !== false && password_verify($password, $user['password'])) {
           return true;
        }
        else return false;
    }
?>