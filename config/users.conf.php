<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
    require_once "classes/users.class.php";
    require_once "controller/users.contr.php";

    $users = new UsersControl();

    if (isset($_POST['opslaan'])) { // Update form
        // Verify if a new password was submitted
        if (!empty($_POST['pwd']) && !empty($POST['pwdRepeat'])) {
            // If there was, store the submitted data in this array
            $data = [
                'ID' => $_POST['ID'],
                'uid' => $_POST['uid'],
                'email' => $_POST['email'],
                'pwd' => $_POST['pwd'],
                'pwdRepeat' => $_POST['pwdRepeat']
            ];
        } else {
            // Store the submitted data in this array
            $data = [
                'ID' => $_POST['ID'],
                'uid' => $_POST['uid'],
                'email' => $_POST['email']
            ];
        }
        $users->verifyUser($data);
    } else {
        // Fout in het formulier.
        $_SESSION['error'] = 'Fout in het formulier.';
    }

    header("location: ../index.php");
    exit();