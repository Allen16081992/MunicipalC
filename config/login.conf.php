<?php // Loubna Faress
if (isset($_POST["submit"])){

    // grabbing the data
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];

    // instantiate signupContr class
    include "classes/secure-db.class.php";
    include "classes/login.class.php";
    include "controller/login-contr.class.php";
    $login = new LoginContr($uid, $pwd);

    // running error handlers and users
    $login->loginUser();

    // going to back to front page
    header("location: ../index.php?error=none");
    exit();
}
?>