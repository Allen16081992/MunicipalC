<?php // Dhr. Allen Pieter

    class ComplaintControl extends Complaint {
        // Consolidate properties
        use InputCheck;
        private $name; 
        private $email;
        private $title;
        private $desc;
        private $gps;
        private $comID;

        public function verifyComplaint($data) {
            // Extract values from $data
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->title = $data['title'];
            $this->desc = $data['desc'];
            $this->gps = $data['location'];
            $this->comID = $data['comID'];

            if(!$this->emptyNames()) {
                // No firstname or lastname provided.
                $_SESSION['error'] = 'Vul uw volledige naam in.';
            } elseif(!$this->emptyEmail()) {
                // No email information provided.
                $_SESSION['error'] = 'Vul uw email adres in.';
            } elseif(!$this->invalidEmail()) {
                // Invalid emailaddress.
                $_SESSION['error'] = 'Vul een geldig email adres in.';
            } elseif(!$this->emptyTitle()) {
                // Invalid Location.
                $_SESSION['error'] = 'Vul uw klacht in.';
            } elseif(!$this->emptyGPS()) {
                // Invalid Location.
                $_SESSION['error'] = 'U heeft geen locatie gekozen.';
            } elseif(!$this->invalidInput()) {
                // Invalid username.
                $_SESSION['error'] = 'Alleen letters en cijfers worden geaccepteerd.';
            } else {
                $this->setComplaint($this->name, $this->email, $this->title, $this->desc, $this->gps, $this->comID = null);
            }
        }
    }