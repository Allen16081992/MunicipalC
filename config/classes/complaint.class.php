<?php // Dhr. Allen Pieter

    class Complaint {

        private $name, $surname, $email, $gps, $db;
    
        public function __construct($name, $surname, $email, $gps, $db) {
            $this->name = $name; 
            $this->surname = $surname;
            $this->email = $email; 
            $this->gps = $gps; 
            $this->db = new Database();
        }

        protected function dbSwitcher() {
            try { // Try the high security database connection
                require_once 'db.class.php';

                // Create instance of Database
                return $this->db->__construct();

            } catch (PDOException $e) { // Log the exception details
                error_log("High security connection failed: " . $e->getMessage(), 0);

                // Try the regular database connection
                require_once 'database.class.php';

                // Create instance of Database
                return $this->db->connect();
            }

            // Whichever connection works, call this
            $this->setComplaint();
        }

        private function setComplaint() {
            
        }
    }