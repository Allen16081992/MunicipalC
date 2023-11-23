<?php
// Loubna Faress
include_once '././include/session_manager.conf.php';
require_once 'errorchecks.contr.php';

class SignupContr extends Signup{
    use InputCheck;
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
        $this->setUser($this->uid, $this->pwd, $this->email);
    }

    private function uidTakenCheck() {
        return $this->checkUser($this->uid, $this->email);
    }
}
?>