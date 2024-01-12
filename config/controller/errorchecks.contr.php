<?php // Dhr. Allen Pieter
    trait InputCheck {

        private function emptyCID() {
            // Controleer of niets is opgegeven.
            return !(empty($this->ID));
        }

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

        private function emptySummary() {
            // Controleer of niets is opgegeven.
            return !(empty($this->desc));
        }

        private function emptyGPS() {
            // Controleer of niets is opgegeven.
            return !(empty($this->gps));
        }

        private function emptyPasswords() {
            // Controleer of niets is opgegeven.
            if (isset($this->pwd) && isset($this->pwdRepeat)) {
                return !(empty($this->pwd) || empty($this->pwdRepeat));
            } 
            elseif(isset($this->pwd)) {
                return !(empty($this->pwd));
            }
        }

        private function invalidEmail() {
            // Controleer of meegegeven informatie een @ bevat.
            return filter_var($this->email, FILTER_VALIDATE_EMAIL);
        }
        
        private function invalidInput() {
            // Controleer of de invoer toegestaan is.
            if ($this->name && !preg_match("/^[a-zA-Z]*$/", $this->name)) {
                return true; // Invalid characters found in name
            }
            if ($this->gps && !preg_match("/^[0-9.,]*$/", $this->gps)) {
                return true; // Invalid characters found in gps
            }
            return false; // No invalid characters found
        }        

        private function passwMatcher() {
            // /echo $this->pwd;
            // echo $this->pwdRepeat;
            // Controleer of wachtwoorden gelijk zijn.
            return $this->pwd === $this->pwdRepeat;
        }

        private function uidTakenCheck() {
            // Controleer of de gebruiker al bestaat.
            return $this->checkUser($this->uid, $this->email);
        }

        private function BindExecutor($stmt) {
            // Geef een foutmelding als de handeling mislukt.
            if($stmt->execute() == false) {
                $stmt = null;
                $_SESSION['error'] = 'Database inquisitie mislukt.';
                header('location: ../index.php');
                exit();
                return false;
            }
        }

        private function BindLoubna($stmt) {
            // Als het aantal rijen uit tabel niks geeft, ga naar homepage
            if($stmt->rowCount() === 0) {
                $stmt = null;
                $_SESSION['error'] = 'Niets gevonden.';
                //header("location: ../index.php");
                //exit();  
                return false;
            }
        }
    }