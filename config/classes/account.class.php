<?php // Dhr. Allen Pieter
    require_once '././include/session_manager.inc.php';
    require_once '././controller/errorchecks.contr.php';

    class Account extends Database {
        use InputCheck;

        protected function updateUser($uid, $email, $pwd, $ID) {
            // Haal het account ID op uit de Database
            // Vergelijk het 'account ID' met het opgegeven ID en E-mailadres.
            $stmt = $this->connect()->prepare("SELECT ID FROM gebruikers WHERE ID = :ID");
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
        
            // Voer controles uit
            $this->BindExecutor($stmt);
            $accountData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$accountData) {
                // User not found, display an appropriate message
                $_SESSION['error'] = 'Geen gebruiker gevonden met het opgegeven ID.';
                return;
            }
        
            if (empty($pwd)) {
                // If password is not provided, update without changing the password
                $stmt = $this->connect()->prepare("UPDATE gebruikers SET Gebruikersnaam = :_uid, Email = :email WHERE ID = :accountData");
                $stmt->bindParam("_uid", $uid, PDO::PARAM_STR);
                $stmt->bindParam("email", $email, PDO::PARAM_STR);
                $stmt->bindParam('accountData', $accountData['ID'], PDO::PARAM_INT);
            } else {
                // Genereer een string en noem het 'een zoutje.'
                $salty = bin2hex(random_bytes(16));

                // Ontmoedig brute-force aanvallen met een vertraging.
                $options = [ 'cost' => 12 ];

                // Encrypt het wachtwoord naar iets heel langs...
                $rehashPwd = password_hash($pwd.$salty, PASSWORD_DEFAULT, $options);

                // If password is provided, update including the password
                $stmt = $this->connect()->prepare("UPDATE gebruikers SET Gebruikersnaam = :_uid, Wachtwoord = :rehashPwd, Email = :email, Salt = :salty WHERE ID = :accountData");
                $stmt->bindParam("_uid", $uid, PDO::PARAM_STR);
                $stmt->bindParam("rehashPwd", $rehashPwd, PDO::PARAM_STR);
                $stmt->bindParam("email", $email, PDO::PARAM_STR);
                $stmt->bindParam("salty", $salty, PDO::PARAM_STR);
                $stmt->bindParam('accountData', $accountData['ID'], PDO::PARAM_INT);
            }
            $this->BindExecutor($stmt);

            // Reset $stmt to null after use
            $stmt = null;
        }

        protected function deleteUser($ID) {
            // Haal het account ID op uit de Database
            // Vergelijk het 'account ID' met het opgegeven ID en E-mailadres.
            $stmt = $this->connect()->prepare("SELECT ID FROM gebruikers WHERE ID = :ID");
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
        
            // Voer controles uit
            $this->BindExecutor($stmt);
            
            $accountData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$accountData) {
                // User not found, display an appropriate message
                $_SESSION['error'] = 'Geen gebruiker gevonden met het opgegeven ID.';
                return;
            }
        
            $stmt = $this->connect()->prepare("DELETE FROM gebruikers WHERE ID = :accountData");
            $stmt->bindParam('accountData', $accountData['ID'], PDO::PARAM_INT);
            $this->BindExecutor($stmt);

            // Op het succesvol Verwijderen van Account, sloop de sessie.
            session_unset();
            session_destroy();

            // Laat een bericht zien
            session_start();
            $_SESSION['success'] = 'Account is verwijderd. U kunt niet meer inloggen.';
            
            // Reset $stmt to null after use
            $stmt = null;
        }
    }