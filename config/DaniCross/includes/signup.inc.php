<?php

if (isset($_POST["submit"])){

    // grabbing the data
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];
    $email = $_POST["email"];

    // instantiate signupContr class
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";
    $signup = new SignupContr($uid, $pwd, $pwdRepeat, $email);


    // running error handlers and users
    $signup->signupUser();
    
    // going to back to front page
    header("location: ../index.php?error=none");
}
?>