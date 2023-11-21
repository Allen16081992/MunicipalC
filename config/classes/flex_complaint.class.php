<?php // Dhr. Allen Pieter
    
    class Complaint {
        

        private $name, $surname, $email, $gps, $db;
    
        public function __construct($name, $surname, $email, $gps, $db) {
            $this->name = $name; $this->surname = $surname;
            $this->email = $email; $this->gps = $gps;
            $this->db = $db;
        }
    }