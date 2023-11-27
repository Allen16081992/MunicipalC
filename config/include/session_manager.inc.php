<?php // Dhr. Allen Pieter 
    if (!isset($_SESSION)) {
        session_start();
    } 
   
    // Periodically regenerate the session ID to tackle session fixation and session hijacking
    function sessionRebuild() {
        $lastRegen = $_SESSION['last_regeneration'] ?? 0;
        $currentTime = time();
        $regenInterval = 900; // Regenerate every 15 minutes

        if ($currentTime - $lastRegen > $regenInterval) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = $currentTime;
        }
    }

    // Webpage Content Generator Functions
    function buildHeader() {
        if (!isset($_SESSION['user_id'])) {
            //$_SESSION['error'] = '401: Ongeautoriseerd Toegang. Log eerst in.';
            echo '
                <ul>
                    <li><a href="#" data-section="home">Home</a></li>
                    <li><a href="#" data-section="login">Inloggen</a></li>
                    <li><a href="#" data-section="signup">Registreren</a></li>
                    <li><a href="#" data-section="complaints">Melding Maken</a></li> 
                </ul>    
            ';
        } else {
            echo '
                <ul>
                    <li class="current">'.$_SESSION['user_name'].'</li>
                    <li>Management</li>
                    <li><a href="#" data-section="logout">Logout</a></li>
                </ul>
            ';                   
        }
    }

    function buildSections() {
        if (!isset($_SESSION['user_id'])) {
            echo '
                <section id="home">
                    <h2>Welcome to Gemeente Havenburg</h2>
                    <p>Explore and engage with your community.</p>
                </section>
            
                <section id="login" class="hidden">
                    <h2>Inloggen</h2>
                    <!-- Login form goes here -->
                    <form action="config/login.conf.php" method="post">
                        <label for="uid">Gebruiker</label>
                        <input type="text" id="uid" name="uid">
                        <label for="pwd">Wachtwoord</label>
                        <input type="password" id="pwd" name="pwd">
                        <button type="submit" name="submit">Inloggen</button>
                    </form> 
                </section>
            
                <section id="signup" class="hidden">
                    <h2>Registreren</h2>
                    <!-- Sign-up form goes here -->
                    <form action="config/signup.conf.php" method="post">
                        <label for="uid">Gebruiker</label>
                        <input type="text" id="uid" name="uid">
                        <label for="email">Email</label>
                        <input type="text" name="email">
                        <label for="pwd">Wachtwoord</label>
                        <input type="password" id="pwd" name="pwd">
                        <label for="pwdRepeat">Herhaal Wachtwoord</label>
                        <input type="password" name="pwdRepeat">
                        <button type="submit" name="submit">Registreren</button>
                    </form> 
                </section>
            
                <section id="complaints" class="hidden">
                    <h2>Submit Complaints</h2>
                    <!-- Complaints form goes here -->
                    <form action="config/complaint.conf.php" method="post">
                        <label for="name">Naam</label>
                        <input type="text" id="name" name="name">
                        <label for="surname">Achternaam</label>
                        <input type="text" id="surname" name="surname">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email">
                        <label for="complaint">Klacht</label>
                        <input type="text" id="complaint" name="complaint">
                        <label for="desc">Beschrijving</label>
                        <textarea id="desc" name="desc" rows="4" cols="50"></textarea>
                        <label for="location">Locatie</label>
                        <input type="text" id="location" name="location">
                        <div id="map"></div>
                        <button type="submit" name="creCom">Verzenden</button>
                    </form> 
                </section>            
            ';
        } else { buildManager(); }
    }

    function buildManager() {
        echo '
            <section id="manage">
                <h2>Klachten Beheer</h2>
                <span>Hier kunt u klachten beheren.</span>
                <table>
                <thead>
                <tr>
        ';
        if (isset($_SESSION['user_id'])) {
            require_once './config/classes/viewComplaints.conf.php';
            if (isset($result)) {
                foreach ($result['columns'] as $column) {
                    echo "<th>$column</th>";
                }
            }
            echo '</tr></thead><tr>';
            if (isset($result)) {
                foreach ($result['complaint'] as $list) {
                    echo "<td>$list</td>";
                }
            }
            echo '</tr>
                </table>
                </section>
            ';
        }
    }