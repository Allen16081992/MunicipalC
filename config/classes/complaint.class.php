<?php // Dhr. Allen Pieter
    require_once '././include/session_manager.inc.php';
    require_once '././controller/errorchecks.contr.php';

    class Complaint extends Database {
        use InputCheck;

        protected function setComplaint($name, $email, $title, $desc, $gps, $ID) {
            // Split the coordinates using the comma as a delimiter
            $splitCoords = explode(', ', $gps);

            // Remove any commas in each part
            $latitude = str_replace(',', '', $splitCoords[0]);
            $longitude = str_replace(',', '', $splitCoords[1]);

            // If $ID is provided, it's an update; otherwise, it's a new complaint
            if ($ID !== null) {
                // Update the complaint
                $stmt = $this->connect()->prepare("UPDATE klachten SET Naam = :name, Email = :email, Klacht = :title, Beschrijving = :desc, Breedtegraad = :latitude, Lengtegraad = :longitude WHERE ID = :ID;");
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
                $stmt->bindParam(":latitude", $latitude, PDO::PARAM_STR);
                $stmt->bindParam(":longitude", $longitude, PDO::PARAM_STR);
                // Watch out, this is a numerical value!
                $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);

                // If this 'trait' fails, kick back to homepage.
                $this->BindExecutor($stmt);

                $stmt = null;
                $_SESSION['success'] = 'Klacht is bijgewerkt.';
            } else {
                // Create a new complaint using $data
                $stmt = $this->connect()->prepare("INSERT INTO klachten (Naam, Email, Klacht, Beschrijving, Breedtegraad, Lengtegraad) VALUES (:name, :email, :title, :desc, :latitude, :longitude);"); 
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
                $stmt->bindParam(":latitude", $latitude, PDO::PARAM_STR);
                $stmt->bindParam(":longitude", $longitude, PDO::PARAM_STR);

                // If this 'trait' fails, kick back to homepage.
                $this->BindExecutor($stmt);

                $stmt = null;
                $_SESSION['success'] = 'Bedankt voor het doorgeven! Wij hebben uw klacht in goede orde ontvangen.';
            }
        }

        protected function deleteComplaint($ID) {
            $stmt = $this->connect()->prepare('DELETE FROM klachten WHERE ID = :ID');
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
         
            // If this 'trait' fails, kick back to homepage.
            $this->BindExecutor($stmt);

            $stmt = null;
            $_SESSION['success'] = 'Klacht is verwijderd.';           
        }
    }