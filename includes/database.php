<?php
  class Database {
    private $db = NULL;

    private function __construct() {
      $this->db = new PDO('sqlite:../database/database.db');
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->db->query('PRAGMA foreign_keys = ON');
      
      if ($this->db == NULL){
        throw new Exception("Failed to open database");
      }
    }

    public static function db() {
        static $inst = NULL;
        
        if($inst === NULL){
            $inst = new Database();
        }
      return $inst->db;
    }
  }

?>