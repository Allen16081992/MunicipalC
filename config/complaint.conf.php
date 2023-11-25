<?php // Dhr. Allen Pieter
    require_once "classes/secure-db.class.php";
    require_once "classes/complaint.class.php";
    require_once "controller/complaint-contr.class.php";
    $complaint = new ComplaintControl();

    if (isset($_POST['creCom'])) { // Create
        // Store the submitted data in an array
        $data = [
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'email' => $_POST['email'],
            'complaint' => $_POST['complaint'],
            'desc' => $_POST['desc'],
            'location' => $_POST['location']
        ];
        $complaint->verifyComplaint($data);

    } elseif (isset($_POST['updCom'])) { // Update
        // Store the submitted data in an array
        $data = [
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'email' => $_POST['email'],
            'complaint' => $_POST['complaint'],
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
            'surname' => $_POST['surname'],
            'email' => $_POST['email'],
            'complaint' => $_POST['complaint'],
            'desc' => $_POST['desc'],
            'gps' => $_POST['location'],
            'comID' => $_POST['comID']
        ];
        $complaint->searchComplaint($data);

    } else { // View All
        // No submission, just call this function
        $complaint->viewComplaints();  
    }

    header("location: ../index.php");
    exit();