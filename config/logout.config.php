<?php // Dhr. Allen Pieter
    // Wipe everything related to the session.
    session_start();
    session_unset();
    session_destroy();
    // Push back to homepage.
    header('location: ../index.php');