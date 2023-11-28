<?php // Dhr. Allen Pieter
    //require_once "include/session_manager.inc.php";
    require_once "classes/secure-db.class.php";
    //require_once "controller/errorchecks.contr.php";
  
    class DbFetcher extends Database {
        public function fetchComplaints() {
            try {
                $stmtColumns = $this->connect()->prepare("SHOW COLUMNS FROM complaints");
                $stmtColumns->execute();
                $columns = $stmtColumns->fetchAll(PDO::FETCH_COLUMN);
    
                $stmtComplaints = $this->connect()->prepare('SELECT * FROM complaints');
                $stmtComplaints->execute();
                $complaintsList = $stmtComplaints->fetchAll(PDO::FETCH_ASSOC);
    
                $complaintsData = [
                    'columns' => $columns,
                    'complaints' => $complaintsList
                ];
    
                return $complaintsData;
            } catch (PDOException $e) {
                // Log the exception details
                error_log("Failed to fetch complaints: " . $e->getMessage(), 0);
                // Throw a user-friendly message
                throw new Exception("Failed to fetch complaints.");
            }
        }
    }