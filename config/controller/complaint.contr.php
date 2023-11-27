<?php // Dhr. Allen Pieter

    class ComplaintControl extends Complaint {
        // Consolidate properties
        use InputCheck;
        private $name; 
        private $surname;
        private $email;
        private $complaint;
        private $desc;
        private $gps;

        public function verifyComplaint($data) {
            // Extract values from $data
            $this->name = $data['name'];
            $this->surname = $data['surname'];
            $this->email = $data['email'];
            $this->complaint = $data['complaint'];
            $this->desc = $data['desc'];
            $this->gps = $data['location'];

            if(!$this->emptyNames()) {
                // No firstname or lastname provided.
                $_SESSION['error'] = 'Vul uw naam en achternaam in.';
            } elseif(!$this->emptyEmail()) {
                // No email information provided.
                $_SESSION['error'] = 'Vul uw email adres in.';
            } elseif(!$this->invalidEmail()) {
                // Invalid emailaddress.
                $_SESSION['error'] = 'Vul een geldig email adres in.';
            } elseif(!$this->emptyComplaint()) {
                // Invalid Location.
                $_SESSION['error'] = 'Vul uw klacht in.';
            } elseif(!$this->emptyGPS()) {
                // Invalid Location.
                $_SESSION['error'] = 'U heeft geen locatie gekozen.';
            } elseif(!$this->invalidInput()) {
                // Invalid username.
                $_SESSION['error'] = 'Alleen letters en cijfers worden geaccepteerd.';
            } else {
                $this->setComplaint($data);
            }
        }
    }