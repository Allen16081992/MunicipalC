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
        if (!isset($_SESSION['gebruiker_id'])) {
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
                    <li class="current">'.$_SESSION['gebruiker_naam'].'</li>
                    <li><a href="#" data-section="account">Account</a></li>
                    <li><a href="#" data-section="admin">Klachten</a></li>
                    <li><a href="#" data-section="logout">Logout</a></li>
                </ul>
            ';                   
        }
    }

    function buildSections() {
        if (!isset($_SESSION['gebruiker_id'])) {
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
                        <input type="text" name="uid">
                        <label for="pwd">Wachtwoord</label>
                        <input type="password" name="pwd">
                        <button type="submit" name="submit">Inloggen</button>
                    </form> 
                </section>
            
                <section id="signup" class="hidden">
                    <h2>Registreren</h2>
                    <!-- Sign-up form goes here -->
                    <form action="config/signup.conf.php" method="post">
                        <label for="uid">Gebruikersnaam</label>
                        <input type="text" name="uid">
                        <label for="email">Email</label>
                        <input type="text" name="email">
                        <label for="pwd">Wachtwoord</label>
                        <input type="password" name="pwd">
                        <label for="pwdRepeat">Herhaal Wachtwoord</label>
                        <input type="password" name="pwdRepeat">
                        <button type="submit" name="submit">Registreren</button>
                    </form> 
                </section>
            
                <section id="complaints" class="hidden">
                    <h2>Submit Complaints</h2>
                    <!-- Complaints form goes here -->
                    <form action="config/complaint.conf.php" method="post">
                        <label for="name">Volledige Naam</label>
                        <input type="text" name="name">
                        <label for="email">Email</label>
                        <input type="text" name="email">
                        <label for="title">Klacht</label>
                        <input type="text" name="title">
                        <label for="desc">Beschrijving</label>
                        <textarea name="desc" rows="4" cols="50"></textarea>
                        <label for="location">Locatie</label>
                        <input type="text" name="location">
                        <div id="map"></div>
                        <button type="submit" name="creCom">Verzenden</button>
                    </form> 
                </section>            
            ';
        }
    }

    function buildManager($complaintsData) {
        echo '
            <section id="account">
                <h2>Account Paneel</h2>
                <p>Wijzig of verwijder je eigen account.</p>
                <form action="config/#" method="post">
                    <label for="uid">Gebruikersnaam</label>
                    <input type="text" name="uid">
                    <label for="email">Email</label>
                    <input type="text" name="email">
                    <label for="pwd">Wachtwoord</label>
                    <input type="password" name="pwd">
                    <label for="pwdRepeat">Herhaal Wachtwoord</label>
                    <input type="password" name="pwdRepeat">
                    <button type="submit" name="opslaan">Opslaan</button>
                    <button type="submit" name="verwijder" class="delete">Account Sluiten</button>
                </form>
            </section>

            <section id="admin" class="hidden">
                <h2>Klachten Paneel</h2>
                <p>Klik op een markering om de klacht van deze locatie te zien.</p>
                <table><thead><tr>
        ';
        // Display column names as table headers
        foreach ($complaintsData['columns'] as $column) {
            echo "<th>$column</th>";
        }
        echo '</tr></thead><tbody><tr>';
        // Display complaint data as table rows
        foreach ($complaintsData['klachten'] as $complaint) {
            foreach ($complaint as $data) {
                echo "<td>$data</td>";
            }
        }
        echo '</tr></tbody></table>
            <div id="kiezen">
                <form action="config/viewComplaints.conf.php" method="post">
                    <label for="zoekbalk">Snelzoek Functie:</label>
                    <select name="zoekbalk" onchange="submitForm(this.form)">
                        <option value="default" selected>Selecteer een klacht...</option>';
                    // Display complaint data as table rows
                    foreach ($complaintsData['klachten'] as $complaint) {
                        echo "<option value='{$complaint['Klacht']}'>{$complaint['Klacht']}</option>";
                    }                             
        echo '      </select>
                </form>
            </div>
            <form>
                <input type="text" id="zoekbalk" name="zoekbalk" placeholder="Voer een ID in...">
                <button type="submit" id="zoek" name="zoeken">#</button>
            </form>
            <div id="map"></div>
            <div class="complaint-card hidden">
                <h3></h3>
                <p></p>
                <p></p>
                <p></p>
            </div>
        </section>';
    }