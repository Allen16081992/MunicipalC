<?php // Dhr. Allen Pieter

    class ComplaintControl extends Complaint {
        // Consolideer eigenschappen (properties)
        use InputCheck;
        private $name; 
        private $email;
        private $title;
        private $desc;
        private $gps;
        private $ID;

        public function verifyComplaint($data) {
            // Informatie halen uit $data
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->title = $data['title'];
            $this->desc = $data['desc'];
            $this->gps = $data['location'];
            $this->ID = isset($data['ID']) ? $data['ID'] : null;

            if(!$this->emptyNames()) {
                // Geen naam opgegeven.
                $_SESSION['error'] = 'Vul uw volledige naam in.';
            } elseif(!$this->emptyEmail()) {
                // Geen email informatie opgegeven.
                $_SESSION['error'] = 'Vul uw email adres in.';
            } elseif(!$this->invalidEmail()) {
                // Ongeldige invoer.
                $_SESSION['error'] = 'Vul een geldig email adres in.';
            } elseif(!$this->emptyTitle()) {
                // Geen klacht opgegeven.
                $_SESSION['error'] = 'Vul uw klacht in.';
            } elseif(!$this->emptySummary()) {
                // Geen klacht opgegeven.
                $_SESSION['error'] = 'Beschrijf uw klacht.';
            } elseif(!$this->emptyGPS()) {
                // Geen locatie opgegeven.
                $_SESSION['error'] = 'U heeft geen locatie geselecteerd.';
            } elseif(!$this->invalidInput()) {
                // Ongeldige invoer.
                $_SESSION['error'] = 'Alleen letters en cijfers worden geaccepteerd.';
            } else {
                $this->setComplaint($this->name, $this->email, $this->title, $this->desc, $this->gps, $this->ID);
            }
        }

        public function verifyID($data) {
            // Informatie halen uit $data
            $this->ID = $data['ID'];

            if(!$this->emptyCID()) {
                // Geen geldig ID.
                $_SESSION['error'] = 'Geen geldig ID.';
            } else { 
                $this->deleteComplaint($this->ID); 
            }
        }
    }