<?php // Loubna Faress
require_once '././include/session_manager.inc.php';
class Login extends Dbh {
   
    protected function getUser($uid, $pwd) {
      //$stmt = $this->connect()->prepare('INSERT INTO users (ID, password, email) VALUES (?, ?, ?);');
      
      //if(!$stmt->execute(array($uid, $pwd))) {
      //    $stmt = null;
      //    header("location: ../index.php?error=stmtfailed");
      //    exit();
      //}

      //if($stmt->rowCount() == 0) {
      //  $stmt = null;
      //  header("location: ../index.php?error=usernotfound");
      //  exit();  
      //}

      //$pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
      //$checkPwd = password_verify($pwd, $pwdHashed[0]["users_pwd"]);

      $stmt = $this->connect()->prepare('SELECT * FROM users WHERE username = ? OR email = ?;');
    
      if(!$stmt->execute(array($uid, $uid))) {
        // Handle error, maybe go to homepage
        $stmt = null;
        $_SESSION['error'] = 'Database query failed.';
        header("location: ../index.php?error=stmtfailed");
        exit();
      }

      if($stmt->rowCount() == 0) {
        // User not found, go to homepage
        $stmt = null;
        $_SESSION['error'] = 'User not found.';
        header("location: ../index.php?error=loginfailed");
        exit();  
      }

      $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $checkPwd = password_verify($pwd, $user[0]["password"]);

      if($checkPwd == false) {
        // Wrong password, redirect to login page with an error message
        header("location: ../index.php?error=wrongpassword");
        exit();  
      } elseif($checkPwd == true) {
        // Password is correct, set session variables
        $_SESSION["user_id"] = $user[0]["userID"];
        $_SESSION["user_name"] = $user[0]["username"];

        // Show a message if Login works.
        $_SESSION['success'] = 'U bent ingelogd!';
      }

      // Close the statement
      $stmt = null;
    }
}
?>