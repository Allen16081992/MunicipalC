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
            $accountID = $stmt->fetch();

            if ($pwd = null) {
                // Doe database opdracht voorbereiden.
                $stmt = $this->connect()->prepare('UPDATE gebruikers SET Gebruikersnaam = :uid, Email = :email, WHERE ID = :accountID;');
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
                $stmt = $this->connect()->prepare("UPDATE gebruikers SET Gebruikersnaam = :uid, Wachtwoord = :reCrypt , Email = :email, Salt = :salty WHERE ID = :accountID;");
                $stmt->bindParam(":reCrypt", $reCrypt, PDO::PARAM_STR);
                $stmt->bindParam(":salty", $salty, PDO::PARAM_STR);
            }
            // Bind de rest van de data
            $stmt->bindParam(":uid", $uid, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);

            // Controleer of er rijen gewijzigd waren
            $this->BindExecutor($stmt);
            $this->BindLoubna($stmt);
            $stmt = null;

            // Laat een bericht zien
            $_SESSION['success'] = 'Uw Account is bijgewerkt.';
        }

        protected function deleteUser($ID, $uid, $email) {
            // Haal het account ID op uit de Database
            // Vergelijk het 'account ID' met het opgegeven ID en E-mailadres.
            $stmt = $this->connect()->prepare("SELECT ID FROM gebruikers WHERE ID = :ID AND Email = :email");
            $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR); 

            // Voer controles uit
            $this->BindExecutor($stmt);
            $this->BindLoubna($stmt);
            $accountID = $stmt->fetch();

            $stmt = $this->connect()->prepare("DELETE FROM gebruikers WHERE ID = :accountID");
            $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);

            // Voer controles uit
            $this->BindExecutor($stmt);
            $stmt = null;

            // Op het succesvol Verwijderen van Account, laat Raymond Westerling los op de sessie.
            session_unset();
            session_destroy();

            // Laat een bericht zien
            session_start();
            $_SESSION['success'] = 'Account is verwijderd. U kunt niet meer inloggen.';
            
            // Pagina opnieuw inladen.
            header('Location: ../index.php?');
            exit(); 
        }
    }