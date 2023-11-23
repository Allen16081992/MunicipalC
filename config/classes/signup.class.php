<?php
class Signup extends Dbh {
   
    protected function setUser($uid, $pwd, $email) {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        $stmt = $this->connect()->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?);');
 
        if(!$stmt->execute(array($uid, $hashedPwd, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($uid, $email) {
        $stmt = $this->connect()->prepare('SELECT COUNT(*) FROM users WHERE username = ? OR email = ?;');
        
        if (!$stmt->execute(array($uid, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        $result = $stmt->fetchColumn();
    
        // If there is a matching user or email, $result will be greater than 0
        return $result === 0;
    }    
}
?>