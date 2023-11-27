<?php // Dhr. Allen Pieter
    trait InputCheck {

        private function emptyUid() {
            // Make sure the submitted values are not empty.
            return !(empty($this->uid));
        }

        private function emptyNames() {
            // Make sure the submitted values are not empty.
            return !(empty($this->name) || empty($this->surname));
        }

        private function emptyEmail() {
            // Make sure the submitted values are not empty.
            return !(empty($this->email));
        }

        private function emptyTitle() {
            // Make sure the submitted values are not empty.
            return !(empty($this->title));
        }

        private function emptyGPS() {
            // Make sure the submitted values are not empty.
            return !(empty($this->gps));
        }

        private function invalidEmail() {
            // Make sure the submitted values contain an @ character.
            return filter_var($this->email, FILTER_VALIDATE_EMAIL);
        }
        
        private function invalidInput() {
            // Make sure the submitted values contain permitted characters.
            return !(
                preg_match("/^[a-zA-Z]*$/", $this->name) &&
                preg_match("/^[a-zA-Z]*$/", $this->surname) &&
                preg_match("/^[0-9.,]*$/", $this->gps)
            );
        }

        private function emptyPassw() {
            // Make sure the submitted values are not empty.
            return !(empty($this->pwd));
        }

        private function emptyPasswords() {
            // Make sure the submitted values are not empty.
            return !(empty($this->pwd) || empty($this->pwdRepeat));
        }

        private function passwMatcher() {
            // Make sure the submitted values are equal.
            return $this->pwd === $this->pwdRepeat;
        }

        private function uidTakenCheck() {
            return $this->checkUser($this->uid, $this->email);
        }

        private function BindExecutor($stmt) {
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