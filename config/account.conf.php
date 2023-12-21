<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
    require_once "classes/account.class.php";
    require_once "controller/account.contr.php";

    if (!isset($_POST['pwd']) || !isset($_POST['pwdRepeat'])) {
        $data = [
            'ID' => $_POST['ID'],
            'uid' => $_POST['uid'],
            'email' => $_POST['email']
        ];
    } else {
        $data = [
            'ID' => $_POST['ID'],
            'uid' => $_POST['uid'],
            'email' => $_POST['email'],
            'pwd' => $_POST['pwd'],
            'pwdRepeat' => $_POST['pwdRepeat']
        ];
    }

    $account = new AccountControl($data);
    $account->verifyUser();

    // Pagina opnieuw inladen.
    header("location: ../index.php");
    exit();