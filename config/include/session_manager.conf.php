<?php // Dhr. Allen Pieter 
    if (!isset($_SESSION)) {
        session_start();
    }
   
    function redirectUnauthorized() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = '401: Ongeautoriseerd Toegang. Log eerst in.';
            header('Location: ././index.php');
            exit;
        } //else { $userID = $_SESSION['user_id']; }
    }
    
    // Periodically regenerate the session ID to tackle session fixation and session hijacking
    function sessionRegen() {
        $lastRegeneration = $_SESSION['last_regeneration'] ?? 0;
        $currentTime = time();
        $regenerationInterval = 900; // Regenerate every 15 minutes

        if ($currentTime - $lastRegeneration > $regenerationInterval) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = $currentTime;
        }
    }