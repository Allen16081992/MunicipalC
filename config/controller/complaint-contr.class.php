<?php // Dhr. Allen Pieter
    // This session_start is solely for displaying error messages.
    require_once '././classes/complaint.class.php';
    require_once 'errorchecks.control.php';

    class ComplaintControl extends Complaint {
        // Consolidate properties
        use InputCheck;
        private $name; 
        private $surname;
        private $email;
        private $gps;
        private $db;

        public function verifyComplaint() {
            if(!$this->emptyNames()) {
                // No firstname or lastname provided.
                $_SESSION['error'] = 'No firstname or lastname provided.';
            } elseif(!$this->emptyGPS()) {
                // Invalid Location.
                $_SESSION['error'] = 'Please provide a valid location.';
            } elseif(!$this->emptyEmail()) {
                // No email information provided.
                $_SESSION['error'] = 'No email provided.';
            } elseif(!$this->invalidEmail()) {
                // Invalid emailaddress.
                $_SESSION['error'] = 'Please enter a valid email address.';
            } elseif(!$this->invalidInput()) {
                // Invalid username.
                $_SESSION['error'] = 'Only alphanumeric characters allowed!';
            } else {
                $this->dbSwitcher();
            }
        }      
    }