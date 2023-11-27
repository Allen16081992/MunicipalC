<?php // Dhr. Allen Pieter
  require_once "secure-db.class.php";
    if (!isset($_SESSION)) {
        session_start();
    } 
  
    class viewComplaints extends Database {

        public function viewComplaints() {
            try {
                $stmt = $this->connect()->prepare("SHOW COLUMNS FROM complaints");
                //$this->BindExecutor($stmt); 
                $column = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
                $stmt = $this->connect()->prepare('SELECT * FROM complaints');
                //$this->BindExecutor($stmt); 
                $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                // Create an associative array to hold both column names and complaint data
                $result = array(
                    'columns' => $column,
                    'complaint' => $list
                );
            
                // Return the associative array
                return $result;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
    }

    $k = new viewComplaints();
    $result = $k->viewComplaints();