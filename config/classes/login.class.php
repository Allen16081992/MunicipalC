<?php // Loubna Faress
  require_once '././include/session_manager.inc.php';

  class Login extends Database {

    protected function getUser($uid, $pwd) {
      
      $stmt = $this->connect()->prepare('SELECT * FROM gebruikers WHERE Gebruikersnaam = ? OR Email = ?;');
    
      if(!$stmt->execute(array($uid, $uid))) {
        // Handle error, maybe go to homepage
        $stmt = null;
        $_SESSION['error'] = 'Database query failed.';
        header("location: ../index.php?error=stmtfailed");
        exit();
      }

      $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

      //============Dhr. Allen Pieter============ 20-12-2023
      // Gebruik nu ook de database kolom 'Salt'
      //=========================================

      $checkPwd = password_verify($pwd.$user[0]['Salt'], $user[0]["Wachtwoord"]);

      if($checkPwd == false) {
        // Wrong password, redirect to login page with an error message
        $_SESSION['error'] = 'Het wachtwoord is fout.';
        header("location: ../index.php?error=wrongpassword");
        exit();  
      } elseif($checkPwd == true) {
        // Password is correct, set user in session variables
        $_SESSION["gebruiker_id"] = $user[0]["ID"];
        $_SESSION["gebruiker_naam"] = $user[0]["Gebruikersnaam"];

        // Show a message if Login works.
        $_SESSION['success'] = 'U bent ingelogd!';
      }

      // Close the statement
      $stmt = null;
    }
  }
?>