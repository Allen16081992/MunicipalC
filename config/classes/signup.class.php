<?php // Loubna Faress
require_once '././include/session_manager.inc.php';
class Signup extends Database {
   
    protected function setUser($uid, $pwd, $email) {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        $stmt = $this->connect()->prepare('INSERT INTO gebruikers (Gebruikersnaam, Wachtwoord, Email) VALUES (?, ?, ?);');
 
        if(!$stmt->execute(array($uid, $hashedPwd, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;

        // Show a message if Signup works.
        $_SESSION['success'] = 'Registratie succesvol!';
    }

    // Check if user already exists in the database
    protected function checkUser($uid, $email) {
        $stmt = $this->connect()->prepare('SELECT ID FROM gebruikers WHERE Gebruikersnaam = ? OR Email = ?;');
        // If this fails, kick back to homepage.
        if(!$stmt->execute(array($uid, $email))) {
            $stmt = null;
            $_SESSION['error'] = 'Database query failed.';
            header('location: ../index.php');
            exit();
        }
        // If we got anything back from the database, do this.
        return $stmt->rowCount() === 0;
    }
}
?>