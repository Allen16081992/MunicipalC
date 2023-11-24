<?php // Loubna Faress
    // Wipe everything related to the session.
    session_start();
    session_unset();
    session_destroy();
?>
<!-- Dhr. Allen Pieter -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tot Ziens! | Gemeente Havenburg</title>
    <!-- Favicon -->
    <?php include_once 'config/include/favicon.inc.php';?>
    <!-- CSS -->
    <link rel="stylesheet" href="css/trongate.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>nav ul { margin-bottom:61px; }</style>
</head>
<body>
    <header>
        <div class="logo-container">
        <a href="index.php"><img src="img/MunicCrest.png" height="40" alt="Brand Signature"></a>
        </div>
        <h1>Gemeente Havenburg</h1>
        <nav>
            <ul>
                <li></li>
            </ul>
        </nav>
    </header>

    <main id="content-container">
        <div class="server-success">U bent uitgelogd.</div>
        <section id="logout">
            <p>Ga terug naar de Homepage.</p>
            <form action="index.php">
                <input type="submit" href="index.php" value="Naar de Homepage">
            </form>
        </section>
    </main>
</body>
</html>