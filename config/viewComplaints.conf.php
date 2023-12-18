<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
    require_once 'controller/errorchecks.contr.php';
  
    class DbFetcher extends Database {
        use InputCheck;

        public function fetchComplaints() {
            try { // Prepare a database querry, then Invoke errorcheck 'BindExecutor'.
                $stmt = $this->connect()->prepare("SHOW COLUMNS FROM klachten");
                $this->BindExecutor($stmt);
                $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
                // Prepare a database querry, then Invoke errorcheck 'BindExecutor'.
                $stmt = $this->connect()->prepare('SELECT * FROM klachten');
                $this->BindExecutor($stmt);
                $complaintsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
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

        public function fetchMarkerJSON() {
            try { // Prepare a database querry, then Invoke errorcheck 'BindExecutor'.
                $stmt = $this->connect()->prepare('SELECT Klacht, Breedtegraad, Lengtegraad FROM klachten');
                $this->BindExecutor($stmt);
                $mapData = $stmt->fetchAll();
    
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
            try { // Prepare a database querry, then Invoke errorcheck 'BindExecutor.'
                $stmt = $this->connect()->prepare('SELECT * FROM klachten WHERE ID = :comkey');
                $stmt->bindParam(":comkey", $comkey, PDO::PARAM_INT);
                $this->BindExecutor($stmt);
                $fetchedData = $stmt->fetch(PDO::FETCH_ASSOC);
        
                // Check if json_encode fails
                if ($fetchedData === false) {
                    error_log("json_encode failed. Last error: " . json_last_error_msg());
                    // Output a message indicating failure
                    echo json_encode(["error" => "Failed to encode data"]);
                } else {
                    // Output the JSON-encoded data
                    echo json_encode($fetchedData);
                }
            } catch (PDOException $e) {
                // Log the exception details
                error_log("Failed to fetch map data: " . $e->getMessage(), 0);
                // Throw a user-friendly message
                throw new Exception("Failed to fetch map data.");
            }
        } 
        
        public function fetchUserData($ID) {
            // Prepare a database querry, then Invoke errorcheck 'BindExecutor.'
            $stmt = $this->connect()->prepare('SELECT ID, Gebruikersnaam, Email FROM gebruikers WHERE ID = :ID;');
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
            $this->BindExecutor($stmt);

            // Oh yeah, and 'BindLoubna' to a table...'
            $this->BindLoubna($stmt); 

            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData;
        }
    }

    $dbFetcher = new DbFetcher();
    
    if (isset($_POST['zoekbalk'])) {
        $comkey = $_POST['zoekbalk'];
        $complaintID = $dbFetcher->fetchComplaintID($comkey);
    } elseif (isset($_GET['mapdata'])) {
        // Check if the 'mapdata' query parameter is present in the URL
        $dbFetcher->fetchMarkerJSON();
    } else {
        $ID = $_SESSION["gebruiker_id"];
        $complaintsData = $dbFetcher->fetchComplaints();
        $userData = $dbFetcher->fetchUserData($ID);
    }