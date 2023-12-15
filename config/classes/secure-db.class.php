<?php // Dhr. Allen Pieter
    class Database {
        private $host = 'localhost';
        private $user = 'root';
        private $passw = '';
        private $db = 'municipaldb';
        private $conn;
    
        // Use the (secure) Database Connection
        private function linkage() {
            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8mb4', $this->user, $this->passw);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Log the exception details
                error_log("Failed to connect to the database: " . $e->getMessage(), 0);
                // Throw a user-friendly message
                throw new Exception("Database connection failed.");
            }
        }        
    
        // Verify if a database connection already exist and use lazy loading. If it doesn't exist, call linkage().
        protected function connect() {
            if (!$this->conn) {
                $this->linkage();
            }
            return $this->conn;
        }
    }
    