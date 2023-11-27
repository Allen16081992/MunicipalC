<?php // Dhr. Allen Pieter
    require_once "include/session_manager.inc.php";
    require_once "classes/secure-db.class.php";
    require_once "controller/errorchecks.contr.php";
  
    class viewComplaints extends Database {
        use InputCheck;

        public function allComplaints() {
            try {
                $stmt = $this->connect()->prepare("SHOW COLUMNS FROM complaints");
                $this->BindExecutor($stmt); 
                $column = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
                $stmt = $this->connect()->prepare('SELECT * FROM complaints');
                $this->BindExecutor($stmt); 
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
    $result = $k->allComplaints();