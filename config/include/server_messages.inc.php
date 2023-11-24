<?php // Dhr. Allen Pieter
    if (isset($_SESSION['error'])) {
        echo '<div class="server-error">'.$_SESSION['error'].'</div>';
        $_SESSION['error'] = null; // Clear the server message on page reload
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="server-success">'.$_SESSION['success'].'</div>';
        $_SESSION['success'] = null; // Clear the server message on page reload
    }