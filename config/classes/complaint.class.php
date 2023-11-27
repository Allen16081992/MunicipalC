<?php // Dhr. Allen Pieter
    require_once '././include/session_manager.inc.php';
    require_once '././controller/errorchecks.contr.php';

    class Complaint extends Database {
        // Consolidate properties
        use InputCheck;
        private $name; 
        private $surname;
        private $email;
        private $complaint;
        private $desc;
        private $gps;
        private $comID;

        protected function setComplaint($data) {
            // Extract values from $data
            $this->name = $data['name'];
            $this->surname = $data['surname'];
            $this->email = $data['email'];
            $this->complaint = $data['complaint'];
            $this->desc = $data['desc'];
            $this->gps = $data['location'];
            $this->comID = $data['comID'];

            // If $comID is provided, it's an update; otherwise, it's a new complaint
            if ($this->comID !== null) {
                // Update the complaint
                $stmt = $this->connect()->prepare("UPDATE complaints SET name = :name, surname = :surname, email = :email, complaint = :complaint, `desc` = :desc, `location` = :location WHERE comID = :comID;");
                $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
                $stmt->bindParam(":surname", $this->surname, PDO::PARAM_STR);
                $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
                $stmt->bindParam(":complaint", $this->complaint, PDO::PARAM_STR);
                $stmt->bindParam(":desc", $this->desc, PDO::PARAM_STR);
                // Watch out, these are numerical values!
                $stmt->bindParam(":location", $this->gps, PDO::PARAM_INT);
                $stmt->bindParam(":comID", $this->comID, PDO::PARAM_INT);

                // If this 'trait' fails, kick back to homepage.
                $this->BindExecutor($stmt);

                $stmt = null;
                $_SESSION['success'] = 'Klacht is bijgewerkt.';
            } else {
                // Create a new complaint using $data
                $stmt = $this->connect()->prepare("INSERT INTO complaints (name, surname, email, complaint, `desc`, location) VALUES (:name, :surname, :email, :complaint, :desc, :location);"); 
                $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
                $stmt->bindParam(":surname", $this->surname, PDO::PARAM_STR);
                $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
                $stmt->bindParam(":complaint", $this->complaint, PDO::PARAM_STR);
                $stmt->bindParam(":desc", $this->desc, PDO::PARAM_STR);
                // Watch out, these are numerical values!
                $stmt->bindParam(":location", $this->gps, PDO::PARAM_INT);

                // If this 'trait' fails, kick back to homepage.
                $this->BindExecutor($stmt);

                $stmt = null;
                $_SESSION['success'] = 'Bedankt voor het doorgeven! Wij hebben uw klacht goed ontvangen.';
            }
        }

        protected function deleteComplaint($data) {
            $this->comID = $data['comID'];

            $stmt = $this->connect()->prepare('DELETE FROM `complaints` WHERE comID = :comID');
            $stmt->bindParam(":comID", $this->comID, PDO::PARAM_INT);
         
            // If this 'trait' fails, kick back to homepage.
            $this->BindExecutor($stmt);

            $stmt = null;
            $_SESSION['success'] = 'Klacht is verwijderd.';           
        }

        protected function searchComplaint($data) {
            // Extract values from $data
            if (isset($data['name'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE `name` = :value');
                $stmt->bindParam(":name", $data['name'], PDO::PARAM_STR);

            } elseif(isset($data['surname'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE `surname` = :value');
                $stmt->bindParam(":surname", $data['surname'], PDO::PARAM_STR);

            } elseif(isset($data['email'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE `email` = :value');
                $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);

            } elseif(isset($data['complaint'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE `complaint` = :value');
                $stmt->bindParam(":complaint", $data['complaint'], PDO::PARAM_STR);

            } elseif(isset($data['gps'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE `location` = :value');
                $stmt->bindParam(":location", $data['gps'], PDO::PARAM_INT);

            } elseif(isset($data['comID'])) {
                $stmt = $this->connect()->prepare('SELECT * FROM `complaints` WHERE `name` = :value');
                $stmt->bindParam(":name", $data['comID'], PDO::PARAM_INT);
            }

            // If this 'trait' fails, kick back to homepage.
            $this->BindExecutor($stmt); 
            $this->BindLoubna($stmt); 

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        }
    }