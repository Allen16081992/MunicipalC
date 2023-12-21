<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
    require_once "classes/users.class.php";
    require_once "controller/users.contr.php";

    if (isset($_POST['opslaan'])) { // Update form
        // Verify if a new password was submitted
        if (isset($_POST['pwd']) && isset($_POST['pwdRepeat'])) {
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
    } elseif (isset($_POST['verwijder'])) { // Update form
        $data = [
            'ID' => $_POST['ID']
        ];
    } else {
        // Fout in het formulier.
        $_SESSION['error'] = "Verifiëren van het formulier voor opslaan en verwijderen mislukt.";
    }
    $users = new UsersControl();
    $users->verifyUser($data);

    header("location: ../index.php");
    exit();