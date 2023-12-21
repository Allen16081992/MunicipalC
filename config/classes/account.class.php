<?php // Dhr. Allen Pieter
    require_once '././include/session_manager.inc.php';
    require_once '././controller/errorchecks.contr.php';

    class Account extends Database {
        use InputCheck;

        protected function updateUser($ID, $uid, $email, $pwd) {
            // Haal het account ID op uit de Database
            // Vergelijk het 'account ID' met het opgegeven ID en E-mailadres.
            $stmt = $this->connect()->prepare('SELECT ID FROM gebruikers WHERE ID = :ID AND Email = :email');
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
            // Voer controles uit
            $this->BindExecutor($stmt);
            $this->BindLoubna($stmt);
            $accountData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$accountData) {
                // No matching user found, display an appropriate message
                $_SESSION['error'] = 'Geen gebruiker gevonden met het opgegeven ID en e-mailadres.';
                return;
            } else {
                if ($pwd == null) { // Corrected the condition
                    // Doe database opdracht voorbereiden.
                    $stmt = $this->connect()->prepare('UPDATE gebruikers SET Gebruikersnaam = :uid, Email = :email WHERE ID = :accountID');
                } else {
                    //==============Dhr. Allen Pieter==============
                        // Genereer een string en noem het 'een zoutje.'
                        $salty = bin2hex(random_bytes(16));
    
                        // Ontmoedig brute-force aanvallen.
                        $options = [ 'cost' => 12 ];
                    //=============================================
    
                    // Encrypt het wachtwoord naar iets heel langs...
                    $reCrypt = password_hash($pwd.$salty, PASSWORD_DEFAULT, $options);
    
                    // Doe database opdracht voorbereiden.
                    $stmt = $this->connect()->prepare("UPDATE gebruikers SET Gebruikersnaam = :uid, Wachtwoord = :reCrypt , Email = :email, Salt = :salty WHERE ID = :accountData;");
                    $stmt->bindParam(":reCrypt", $reCrypt, PDO::PARAM_STR);
                    $stmt->bindParam(":salty", $salty, PDO::PARAM_STR);
                }
                // Bind de rest van de data
                $stmt->bindParam(":uid", $uid, PDO::PARAM_STR);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
                $stmt->execute(array(':accountData' => $accountData['ID']));
    
                // Controleer of er rijen gewijzigd waren
                $this->BindExecutor($stmt);
                $this->BindLoubna($stmt);
                $stmt = null;
    
                // Laat een bericht zien
                $_SESSION['success'] = 'Uw Account is bijgewerkt.';  
            }
        }

        protected function deleteUser($ID) {
            // Haal het account ID op uit de Database
            // Vergelijk het 'account ID' met het opgegeven ID en E-mailadres.
            $stmt = $this->connect()->prepare("SELECT ID FROM gebruikers WHERE ID = :ID");
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
        
            // Voer controles uit
            $this->BindExecutor($stmt);
            if ($stmt->rowCount() == 0) {
                // User not found, display an appropriate message
                $_SESSION['error'] = 'Geen gebruiker gevonden met het opgegeven ID.';
                return;
            }
            $accountData = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $stmt = $this->connect()->prepare("DELETE FROM gebruikers WHERE ID = :accountData");
            $stmt->execute(array(':accountData' => $accountData['ID']));

            // Verify if the expected row was deleted
            if ($stmt->rowCount() == 0) {
                // If no rows were deleted, display an appropriate message
                $_SESSION['error'] = 'Account verwijderen mislukt. Geen overeenkomende gebruiker gevonden.';
            } else {
                // Op het succesvol Verwijderen van Account, sloop de sessie.
                session_start();
                session_unset();
                session_destroy();

                // Laat een bericht zien
                session_start();
                $_SESSION['success'] = 'Account is verwijderd. U kunt niet meer inloggen.';
            }
            // Reset $stmt to null after use
            $stmt = null;
        }
    }