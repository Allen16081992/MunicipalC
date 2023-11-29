<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
    require_once "classes/complaint.class.php";
    require_once "controller/complaint.contr.php";

    $complaint = new ComplaintControl();

    if (isset($_POST['creCom'])) { // Create
        // Store the submitted data in an array
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'title' => $_POST['title'],
            'desc' => $_POST['desc'],
            'location' => $_POST['location']
        ];
        $complaint->verifyComplaint($data);

    } elseif (isset($_POST['updCom'])) { // Update
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
        $complaint->deleteComplaint($data);

    } elseif (isset($_POST['searchCom'])) { // Search
        // Store the submitted data in an array
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'title' => $_POST['title'],
            'desc' => $_POST['desc'],
            'gps' => $_POST['location'],
            'comID' => $_POST['comID']
        ];
        $complaint->searchComplaint($data);

    } // View All
    //$complaint->viewComplaints();  

    header("location: ../index.php");
    exit();