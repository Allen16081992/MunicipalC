<?php // Dhr. Allen Pieter

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $gps = $_POST['location'];

    // Initialise signup class
    require_once "classes/complaint.class.php";
    require_once "controller/complaint-contr.class.php";

    $complaint = new ComplaintControl($name, $surname, $email, $gps, $db);
    $complaint->verifyComplaint();
}