<?php // Dhr. Allen Pieter
    // Secure Database Credentials
    require_once 'ect/credent.db.php';

    class Database extends Credent {
        private $conn;

        public function __construct() {
            // Call parent constructor to initialize properties securely
            parent::__construct($this->host, $this->db, $this->user, $this->pwd);
            $this->linkage();
        }       

        // Use the (secure)Database Connection
        private function linkage() {
            try {
                $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8mb4;sslmode=require',$this->user,$this->pwd);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->conn;
                
            } catch (PDOException $e) {
                // Log the exception details
                error_log("Failed to connect to the database: " . $e->getMessage(), 0);
                // Throw a user-friendly message
                throw new Exception("Database connection failed.");
            }
        }
    }