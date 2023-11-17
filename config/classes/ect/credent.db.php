<?php // Dhr. Allen Pieter
    class Credent {
        // Restrict access to properties
        protected $host = 'localhost';
        protected $user = 'root';
        protected $pwd = '';
        protected $db = 'municipaldb';

        // Only initialise credentials here
        protected function __construct($host, $db, $user, $pwd) {
            $this->host = $host;
            $this->db = $db;
            $this->user = $user;
            $this->pwd = $pwd;
        }
    }