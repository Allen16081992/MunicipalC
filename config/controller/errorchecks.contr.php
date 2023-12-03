<?php // Dhr. Allen Pieter
    trait InputCheck {

        private function emptyUid() {
            // Controleer of niets is opgegeven.
            return !(empty($this->uid));
        }

        private function emptyNames() {
            // Controleer of niets is opgegeven.
            return !(empty($this->name));
        }

        private function emptyEmail() {
            // Controleer of niets is opgegeven.
            return !(empty($this->email));
        }

        private function emptyTitle() {
            // Controleer of niets is opgegeven.
            return !(empty($this->title));
        }

        private function emptyGPS() {
            // Controleer of niets is opgegeven.
            return !(empty($this->gps));
        }

        private function invalidEmail() {
            // Controleer of meegegeven informatie een @ bevat.
            return filter_var($this->email, FILTER_VALIDATE_EMAIL);
        }
        
        private function invalidInput() {
            // Controleer of de invoer toegestaan is.
            return !(
                preg_match("/^[a-zA-Z]*$/", $this->name) &&
                preg_match("/^[a-zA-Z]*$/", $this->surname) &&
                preg_match("/^[0-9.,]*$/", $this->gps)
            );
        }

        private function emptyPassw() {
            // Controleer of niets is opgegeven.
            return !(empty($this->pwd));
        }

        private function emptyPasswords() {
            // Controleer of niets is opgegeven.
            return !(empty($this->pwd) || empty($this->pwdRepeat));
        }

        private function passwMatcher() {
            // Controleer of wachtwoorden gelijk zijn.
            return $this->pwd === $this->pwdRepeat;
        }

        private function uidTakenCheck() {
            // Controleer of de gebruiker al bestaat.
            return $this->checkUser($this->uid, $this->email);
        }

        private function BindExecutor($stmt) {
            // Geef een foutmelding als de handeling mislukt.
            if(!$stmt->execute()) {
                $stmt = null;
                $_SESSION['error'] = 'Database query failed.';
                header('location: ../index.php');
                exit();
            }
        }

        // Niks te zien hier
        private function BindLoubna($stmt) {
            // Als het aantal rijen uit Tabel niets oplevert, ga naar homepage
            if($stmt->rowCount() == 0) {
                $stmt = null;
                $_SESSION['error'] = 'Niets gevonden.';
                header("location: ../index.php");
                exit();  
            }
        }
    }