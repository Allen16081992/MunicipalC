<?php // Loubna Faress
require_once '././include/session_manager.inc.php';
require_once 'errorchecks.contr.php';

class LoginContr extends Login {
    use InputCheck; // errorchecks.contr.php

    // properties
    private $uid;
    private $pwd;

    public function __construct($uid, $pwd) {
        $this->uid = $uid;
        $this->pwd = $pwd;
    }

    public function loginUser() {
        if(!$this->emptyUid()) {
            $_SESSION['error'] = 'Voer uw Gebruikersnaam in.';
            header("location: ../index.php?error=emptyname");
            exit();
        }
        if(!$this->emptyPasswords()) {
            $_SESSION['error'] = 'Voer uw Wachtwoord in.';
            header("location: ../index.php?error=emptypassword");
            exit();
        } 

        // Go on with logging in
        $this->getUser($this->uid, $this->pwd);
    }
}
?>