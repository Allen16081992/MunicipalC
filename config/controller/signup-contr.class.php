<?php // Loubna Faress
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
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        if (!$this->invalidEmail()) {
            header("location: ../index.php?error=email");
            exit();
        }
        if (!$this->passwMatcher()) {
            header("location: ../index.php?error=passwordmatch");
            exit();
        }
        if (!$this->uidTakenCheck()) {
            header("location: ../index.php?error=user_creation_denied");
            exit();
        }
        $this->setUser($this->uid, $this->pwd, $this->email);
    }
}
?>