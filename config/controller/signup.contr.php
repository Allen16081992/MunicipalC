<?php // Loubna Faress
require_once '././include/session_manager.inc.php';
require_once 'errorchecks.contr.php';

class SignupContr extends Signup{
    use InputCheck; // errorchecks.contr.php

    // properties
    private $uid;
    private $email;
    private $pwd;
    private $pwdRepeat;
    private $hashedPwd;

    public function __construct($uid, $email, $pwd, $pwdRepeat) {
        $this->uid = $uid;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
    }

    public function signupUser() {
        if (!$this->emptyUid()) {
            $_SESSION['error'] = 'Voer uw gebruikersnaam in.';
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        if (!$this->emptyEmail()) {
            $_SESSION['error'] = 'Voer uw emailadres in.';
            header("location: ../index.php?error=email");
            exit();
        }
        if (!$this->invalidEmail()) {
            $_SESSION['error'] = 'Voer een geldig emailadres in.';
            header("location: ../index.php?error=email");
            exit();
        }
        if(!$this->emptyPasswords()) {
            $_SESSION['error'] = 'Voer uw Wachtwoord in.';
            header("location: ../index.php?error=emptypassword");
            exit();
        } 
        if (!$this->passwMatcher()) {
            $_SESSION['error'] = 'Beide wachtwoorden moeten gelijk zijn.';
            header("location: ../index.php?error=passwordmatch");
            exit();
        }
        if (!$this->uidTakenCheck()) {
            $_SESSION['error'] = 'Gebruiker bestaat al.';
            header("location: ../index.php?error=user_creation_denied");
            exit();
        }
        $this->setUser($this->uid, $this->pwd, $this->email);
    }
}
?>