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

        private function emptyGPS() {
            // Make sure the submitted values are not empty.
            return !(empty($this->gps));
        }

        private function invalidInput() {
            // Make sure the submitted values contain permitted characters.
            return !(
                preg_match("/^[a-zA-Z]*$/", $this->name) &&
                preg_match("/^[a-zA-Z]*$/", $this->surname) &&
                preg_match("/^[0-9.,]*$/", $this->gps)
            );
        }

        private function emptyEmail() {
            // Make sure the submitted values are not empty.
            return !(empty($this->email));
        }

        private function invalidEmail() {
            // Make sure the submitted values contain an @ character.
            return filter_var($this->email, FILTER_VALIDATE_EMAIL);
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
    }