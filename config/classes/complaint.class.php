<?php // Dhr. Allen Pieter
    require_once '././include/session_manager.inc.php';
    require_once '././controller/errorchecks.contr.php';

    class Complaint extends Database {
        // Consolidate properties
        use InputCheck;

        protected function setComplaint($name, $email, $title, $desc, $gps, $comID) {
            // Split the coordinates using the comma as a delimiter
            $splitCoords = explode(', ', $gps);

            // Remove any commas in each part
            $latitude = str_replace(',', '', $splitCoords[0]);
            $longitude = str_replace(',', '', $splitCoords[1]);

            // If $comID is provided, it's an update; otherwise, it's a new complaint
            if ($comID !== null) {
                // Update the complaint
                $stmt = $this->connect()->prepare("UPDATE complaints SET name = :name, email = :email, title = :title, `desc` = :desc, lat = :latitude, lon = longitude WHERE comID = :comID;");
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
                // Watch out, these are numerical values!
                $stmt->bindParam(":lat", $latitude, PDO::PARAM_INT);
                $stmt->bindParam(":lon", $longitude, PDO::PARAM_INT);
                $stmt->bindParam(":comID", $comID, PDO::PARAM_INT);

                // If this 'trait' fails, kick back to homepage.
                $this->BindExecutor($stmt);

                $stmt = null;
                $_SESSION['success'] = 'Klacht is bijgewerkt.';
            } else {
                // Create a new complaint using $data
                $stmt = $this->connect()->prepare("INSERT INTO complaints (name, email, title, `desc`, lat, lon) VALUES (:name, :email, :title, :desc, :latitude, :longitude);"); 
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
                // Watch out, these are numerical values!
                $stmt->bindParam(":lat", $latitude, PDO::PARAM_INT);
                $stmt->bindParam(":lon", $longitude, PDO::PARAM_INT);

                // If this 'trait' fails, kick back to homepage.
                $this->BindExecutor($stmt);

                $stmt = null;
                $_SESSION['success'] = 'Bedankt voor het doorgeven! Wij hebben uw klacht goed ontvangen.';
            }
        }

        protected function deleteComplaint($data) {
            $comID = $data['comID'];

            $stmt = $this->connect()->prepare('DELETE FROM `complaints` WHERE comID = :comID');
            $stmt->bindParam(":comID", $comID, PDO::PARAM_INT);
         
            // If this 'trait' fails, kick back to homepage.
            $this->BindExecutor($stmt);

            $stmt = null;
            $_SESSION['success'] = 'Klacht is verwijderd.';           
        }

        protected function searchComplaint($data) {
            // Extract values from $data
            if (isset($data['name'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE `name` = :name');
                $stmt->bindParam(":name", $data['name'], PDO::PARAM_STR);

            } elseif(isset($data['email'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE email = :email');
                $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);

            } elseif(isset($data['title'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE title = :title');
                $stmt->bindParam(":title", $data['title'], PDO::PARAM_STR);

            } elseif(isset($data['comID'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE `comID` = :comID');
                $stmt->bindParam(":comID", $data['comID'], PDO::PARAM_INT);
            }

            // If this 'trait' fails, kick back to homepage.
            $this->BindExecutor($stmt); 
            $this->BindLoubna($stmt); 

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        }
    }