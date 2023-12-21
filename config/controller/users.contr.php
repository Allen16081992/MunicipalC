<?php // Dhr. Allen Pieter
    require_once '././include/session_manager.inc.php';
    require_once 'errorchecks.contr.php';
    
    class UsersControl extends Users {
        // Consolideer eigenschappen (properties)
        use InputCheck;
        private $ID;
        private $uid; 
        private $email;
        private $pwd;
        private $pwdRepeat;

        public function verifyUser($data) {
            // Informatie halen uit $data
            $this->ID = $data['ID'];
            $this->uid = $data['uid'];
            $this->email = $data['email'];
            $this->pwd = $data['pwd'];
            $this->pwdRepeat = $data['pwdRepeat'];

            if (!empty($pwd) && !empty($pwdRepeat)) {
                if(!$this->emptyUid()) {
                    // Geen naam opgegeven.
                    $_SESSION['error'] = 'Vul uw gebruikersnaam in.';
                } elseif(!$this->emptyEmail()) {
                    // Geen email informatie opgegeven.
                    $_SESSION['error'] = 'Vul uw email adres in.';
                } elseif(!$this->emptyPasswords()) {
                    // Geen wachtwoord opgegeven.
                    $_SESSION['error'] = 'Voer uw Wachtwoord in.';
                } elseif (!$this->passwMatcher()) {
                    // Geen wachtwoord overeenkomst.
                    $_SESSION['error'] = 'Beide wachtwoorden moeten gelijk zijn.';
                } else {
                    $this->updateUser($this->ID, $this->uid, $this->pwd, $this->email);
                }
            } else {
                if(!$this->emptyUid()) {
                    // Geen naam opgegeven.
                    $_SESSION['error'] = 'Vul uw gebruikersnaam in.';
                } elseif(!$this->emptyEmail()) {
                    // Geen email informatie opgegeven.
                    $_SESSION['error'] = 'Vul uw email adres in.';
                } else {
                    $this->updateUser($this->ID, $this->uid, $this->pwd, $this->email);
                }
            }
        }
    }