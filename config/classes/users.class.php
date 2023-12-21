<?php // Dhr. Allen Pieter
    require_once '././include/session_manager.inc.php';
    require_once '././controller/errorchecks.contr.php';

    class Users extends Database {
        use InputCheck;

        protected function updateUser($ID, $uid, $pwd, $email) {
            // Verify if a Password change was requested.
            if (!empty($pwd)) {
                // Prepare a database querry 
                $stmt = $this->connect()->prepare('UPDATE gebruikers SET Wachtwoord = :pwd, Gebruikersnaam = :uid, Email = :email WHERE ID = :ID;');
                $stmt->bindParam(":pwd", $pwd, PDO::PARAM_STR);
            } else {
                // Prepare a shorter database querry 
                $stmt = $this->connect()->prepare('UPDATE gebruikers SET Gebruikersnaam = :uid, Email = :email WHERE ID = :ID;');
            }
            $stmt->bindParam(":uid", $uid, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            // Watch out, this is a numerical value!
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);  

            // Invoke errorcheck 'BindExecutor.'
            $this->BindExecutor($stmt);
            $stmt = null;
    
            // Show a message if Signup works.
            $_SESSION['success'] = 'Account is bijgewerkt.';
        }

        protected function deleteUser($ID) {
            // Prepare a database query
            $stmt = $this->connect()->prepare('DELETE FROM gebruikers WHERE ID = :ID;');
            // Watch out, this is a numerical value!
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
        
            // Invoke errorcheck 'BindExecutor.'
            $this->BindExecutor($stmt);
            $stmt = null;
        
            // Clear the session and destroy it on a successful account deletion
            session_start();
            session_unset();
            session_destroy();
            session_start();
        
            // Show a message if the account deletion works.
            $_SESSION['success'] = 'Account is verwijderd. U kunt niet meer inloggen.';
        }
    }