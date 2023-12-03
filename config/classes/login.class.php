<?php // Loubna Faress
  require_once '././include/session_manager.inc.php';
  require_once '././controller/errorchecks.contr.php';

  class Login extends Database {
    use InputCheck;

    protected function getUser($uid, $pwd) {
      
      $stmt = $this->connect()->prepare('SELECT * FROM gebruikers WHERE Gebruikersnaam = ? OR Email = ?;');
    
      if(!$stmt->execute(array($uid, $uid))) {
        // Handle error, maybe go to homepage
        $stmt = null;
        $_SESSION['error'] = 'Database query failed.';
        header("location: ../index.php?error=stmtfailed");
        exit();
      }

      // If this 'trait' fails, kick back to homepage.
      $this->BindLoubna($stmt); 

      $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $checkPwd = password_verify($pwd, $user[0]["Wachtwoord"]);

      if($checkPwd == false) {
        // Wrong password, redirect to login page with an error message
        header("location: ../index.php?error=wrongpassword");
        exit();  
      } elseif($checkPwd == true) {
        // Password is correct, set session variables
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