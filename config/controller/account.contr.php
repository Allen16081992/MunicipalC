<?php // Dhr. Allen Pieter
    class AccountControl extends Account {
        // Consolideer eigenschappen (properties)
        use InputCheck;
        private $ID;
        private $uid; 
        private $email;
        private $pwd;
        private $pwdRepeat;

        public function __construct($data) {
            $this->ID = $data['ID'];
            $this->uid = $data['uid'];
            $this->email = $data['email'];

            // Conditionele parameters zijn echt tricky...
            $this->pwd = isset($data['pwd']) ? $data['pwd'] : null;
            $this->pwdRepeat = isset($data['pwdRepeat']) ? $data['pwdRepeat'] : null;
        }

        public function verifyUser() {
            // Controleer of een wachtwoord was opgegeven
            if ($this->pwd != null && $this->pwdRepeat != null) {
                if (!$this->passwMatcher()) {
                    // Wachtwoorden moeten gelijk zijn.
                    $_SESSION['error'] = 'Wachtwoorden zijn niet gelijk.';
                } else {
                    $_SESSION['success'] = 'Wachtwoord zijn bijgewerkt.';
                }
            }

            // Voer overige controles uit
            if(!$this->emptyCID()) {
                // Geen account gevonden.
                $_SESSION['error'] = 'Identificatie van account mislukt.';
            } elseif(!$this->emptyUid()) {
                // Geen gebruikernaam opgegeven.
                $_SESSION['error'] = 'Er is geen gebruikersnaam opgegeven.';
            } elseif(!$this->emptyEmail()) {
                // Geen email informatie opgegeven.
                $_SESSION['error'] = 'Vul uw email adres in.';
            } elseif(!$this->invalidEmail()) {
                // Ongeldige invoer.
                $_SESSION['error'] = 'Vul een geldig email adres in.';
            } 

            // Verifieer of het account Gewijzigd of Verwijderd moet worden
            if (isset($_POST['updAcc'])) { // Update
                $this->updateUser($this->uid, $this->email, $this->pwd, $this->ID);

            } elseif (isset($_POST['delAcc'])) { // Delete
                $this->deleteUser($this->ID);
            } else {
                // Ongeldige invoer.
                $_SESSION['error'] = 'Knop verificatie mislukt.';
            }
        }  
    }