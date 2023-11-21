<?php // Dhr. Allen Pieter
    // This session_start is solely for displaying error messages.
    //require_once '././peripherals/session_management.config.php';
    require_once 'errorchecks.control.php';

    class ComplaintControl extends Complaint {
        use ErrorCheckers;

        private $name; 
        private $surname;
        private $email;
        private $gps;
        private $db;

        public function dbSwitcher() {
            try { // Try the high security database connection
                require_once 'db.class.php';

                // Create instance of Database
                $this->db = new Database();
                return $this->db->__construct();

            } catch (PDOException $e) { // Log the exception details
                error_log("High security connection failed: " . $e->getMessage(), 0);

                // Try the regular database connection
                require_once 'database.class.php';

                // Create instance of Database
                $this->db = new Database();
                return $this->db->connect();
            }

            // Whichever connection works, call this
            $this->flexComplaint();
        }

        private function flexComplaint() {
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
                $this->setComplaint(
                    $this->name, $this->surname, 
                    $this->email, $this->gps
                );
            }
        }      
    }