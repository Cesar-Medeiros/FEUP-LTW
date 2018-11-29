<?php
    include_once('../includes/database.php');

    function getUsers(){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User');
        $stmt->execute();
        return $stmt->fetchAll(); 
    }

    function addUser($username, $password){
        $db = Database::db();
        $stmt = $db->prepare('INSERT INTO User VALUES(NULL, ?, ?)');
        $stmt->execute(array($username, $password));
    }

    function userExist($username){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User WHERE username = ?');
        $stmt->execute(array($username));
        return $stmt->fetch() ? true : false; 
    }

    function checkUserPassword($username, $password){
        $db = Database::db();
        $stmt = $db->prepare('SELECT * from User WHERE username = ? AND password = ?');
        $stmt->execute(array($username, $password));
        return $stmt->fetch() ? true : false; 
    }
?>