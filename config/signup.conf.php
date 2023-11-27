<?php // Loubna Faress

if (isset($_POST["submit"])){

    // grabbing the data
    $uid = $_POST["uid"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];

    // instantiate signupContr class
    include "classes/secure-db.class.php";
    include "classes/signup.class.php";
    include "controller/signup.contr.php";
    $signup = new SignupContr($uid, $email, $pwd, $pwdRepeat);

    // running error handlers and users
    $signup->signupUser();
    
    // going to back to front page
    header("location: ../index.php?error=none");
    exit();
}
?>