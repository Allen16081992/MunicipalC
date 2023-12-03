<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
  
    class DbFetcher extends Database {
        public function fetchComplaints() {
            try {
                $stmtColumns = $this->connect()->prepare("SHOW COLUMNS FROM klachten");
                $stmtColumns->execute();
                $columns = $stmtColumns->fetchAll(PDO::FETCH_COLUMN);
    
                $stmtComplaints = $this->connect()->prepare('SELECT * FROM klachten');
                $stmtComplaints->execute();
                $complaintsList = $stmtComplaints->fetchAll(PDO::FETCH_ASSOC);
    
                $complaintsData = [
                    'columns' => $columns,
                    'klachten' => $complaintsList
                ];
    
                return $complaintsData;
            } catch (PDOException $e) {
                // Log the exception details
                error_log("Failed to fetch complaints: " . $e->getMessage(), 0);
                // Throw a user-friendly message
                throw new Exception("Failed to fetch complaints.");
            }
        }

        public function fetchComplaintsJSON() {
            try {
                $stmtComplaints = $this->connect()->prepare('SELECT Klacht, Breedtegraad, Lengtegraad FROM klachten');
                $stmtComplaints->execute();
                $mapData = $stmtComplaints->fetchAll(PDO::FETCH_ASSOC);
    
                // Return JSON-encoded data
                header('Content-Type: application/json');
                echo json_encode($mapData);
            } catch (PDOException $e) {
                // Log the exception details
                error_log("Failed to fetch map data: " . $e->getMessage(), 0);
                // Throw a user-friendly message
                throw new Exception("Failed to fetch map data.");
            }
        }

        public function fetchComplaintID($comkey) {
            try {
                $stmt = $this->connect()->prepare('SELECT Naam, Email, Klacht, Beschrijving FROM klachten WHERE ID = :comkey');
                $stmt->bindParam(":comkey", $comkey, PDO::PARAM_STR);
                $stmt->execute();
                $klachtID = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Return results
                header('Content-Type: application/json');
                echo json_encode($klachtID);

            } catch (PDOException $e) {
                // Log the exception details
                error_log("Failed to fetch map data: " . $e->getMessage(), 0);
                // Throw a user-friendly message
                throw new Exception("Failed to fetch map data.");
            }
        }
    }

    $dbFetcher = new DbFetcher();
    if (isset($_POST['zoekbalk'])) {
        $comkey = $_POST['zoekbalk'];
        $dbFetcher->fetchComplaintID($comkey);
    } elseif (isset($_GET['mapdata'])) {
        // Check if the 'mapdata' query parameter is present in the URL
        $dbFetcher->fetchComplaintsJSON();
    } else {
        // Otherwise, fetch complaints data
        $complaintsData = $dbFetcher->fetchComplaints();
    }