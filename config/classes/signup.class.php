<?php // Loubna Faress
require_once '././include/session_manager.inc.php';
class Signup extends Database {
   
    protected function setUser($uid, $pwd, $email) {
        //==============Dhr. Allen Pieter==============
            // Genereer een string en noem het 'een zoutje.'
            $salty = bin2hex(random_bytes(16));

            // Ontmoedig brute-force aanvallen.
            $options = [ 'cost' => 12 ];
        //=============================================

        // Encrypt het wachtwoord naar iets heel langs...
        $hashedPwd = password_hash($pwd.$salty, PASSWORD_DEFAULT, $options);

        // Doe database opdracht voorbereiden.
        $stmt = $this->connect()->prepare('INSERT INTO gebruikers (Gebruikersnaam, Wachtwoord, Email, Salt) VALUES (?, ?, ?, ?);');

        // Voer het uit, als het niet lukt, ga terug
        if(!$stmt->execute(array($uid, $hashedPwd, $email, $salty))) {
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
        // Doe database opdracht voorbereiden.
        $stmt = $this->connect()->prepare('SELECT ID FROM gebruikers WHERE Gebruikersnaam = ? OR Email = ?;');

        // Voer het uit, als het niet lukt, ga terug
        if(!$stmt->execute(array($uid, $email))) {
            $stmt = null;
            $_SESSION['error'] = 'Database query failed.';
            header('location: ../index.php');
            exit();
        }

        return $stmt->rowCount() === 0;
    }
}
?>