<?php // Dhr. Allen Pieter

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $gps = $_POST['location'];
    $db;

    // Initialise signup class
    require_once "classes/flex_complaint.class.php";
    require_once "controller/flex_complaint.control.php";

    $complaint = new ComplaintControl($name, $surname, $email, $gps, $db);
    $complaint->dbSwitcher();
}