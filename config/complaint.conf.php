<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
    require_once "classes/complaint.class.php";
    require_once "controller/complaint.contr.php";

    $complaint = new ComplaintControl();

    if (isset($_POST['creCom']) || isset($_POST['updCom'])) { // Create - Update
        // Store the submitted data in an array
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'title' => $_POST['title'],
            'desc' => $_POST['desc'],
            'location' => $_POST['location'],
            'comID' => $_POST['comID']
        ];
        $complaint->verifyComplaint($data);

    } elseif (isset($_POST['delCom'])) { // Delete
        // Catch the submitted data
        $data = ['comID' => $_POST['comID'] ];
        $complaint->verifyID($data);
    }

    header("location: ../index.php");
    exit();