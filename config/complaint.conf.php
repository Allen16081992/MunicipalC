<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
    require_once "classes/complaint.class.php";
    require_once "controller/complaint.contr.php";

    $complaint = new ComplaintControl();

    if (isset($_POST['creCom'])) { // Create
        // Sla de data op in een array
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'title' => $_POST['title'],
            'desc' => $_POST['desc'],
            'location' => $_POST['location']
        ];
        $complaint->verifyComplaint($data);

    } elseif (isset($_POST['updCom'])) { // Update
        // Sla de data op in een array
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'title' => $_POST['title'],
            'desc' => $_POST['desc'],
            'location' => $_POST['location'],
            'ID' => $_POST['ID']
        ];
        $complaint->verifyComplaint($data);
    } elseif (isset($_POST['delCom'])) { // Delete
        // Sla de data op in een array
        $data = ['ID' => $_POST['ID'] ];
        $complaint->verifyID($data);
    }

    header("location: ../index.php");
    exit();