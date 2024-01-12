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

    // Webpage Navigation Generator
    function buildHeader() {
        if (!isset($_SESSION['gebruiker_id'])) {
            //$_SESSION['error'] = '401: Ongeautoriseerd Toegang. Log eerst in.';
            //<li><a href="#" data-section="home">Home</a></li>
            echo '
                <ul>
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
                    <li><a href="#" data-section="logout">Uitloggen</a></li>
                </ul>
            ';                   
        }
    }

    // Webpage Content Generator
    function buildSections() {
        if (!isset($_SESSION['gebruiker_id'])) {
            echo '
                <section id="home">
                    <div id="blokje1"></div>
                    <h2>Welkom, Hoe kunnen wij u helpen?</h2>
                    <p>U kunt hier terecht met eventuele klachten of opmerkingen over uw omgeving.</p>
                    <div class="image">
                        <img src="img/zeeland.jpg" alt="" width="200">
                    </div>
                    <button data-section="complaints">Ik wil iets melden</button>
                    <div id="blokje2"></div>
                </section>
            
                <section id="login" class="hidden">
                    <h2>Inloggen</h2>
                    <!-- Login form goes here -->
                    <form action="config/login.conf.php" method="post">
                        <label for="uid">Gebruikersnaam</label>
                        <input type="text" name="uid">
                        <label for="pwd">Wachtwoord</label>
                        <input type="password" name="pwd">
                        <button type="submit" name="login">Inloggen</button>
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
                        <button type="submit" name="register">Registreren</button>
                    </form> 
                </section>
            
                <section id="complaints" class="hidden">
                    <h2>Een melding maken</h2>
                    <!-- Complaints form goes here -->
                    <form action="config/complaint.conf.php" method="post">
                        <label for="name">Naam Volledig</label>
                        <input type="text" name="name">
                        <label for="email">Email</label>
                        <input type="text" name="email">
                        <label for="title">Uw Klacht</label>
                        <input type="text" name="title">
                        <label for="desc">Een korte beschrijving</label>
                        <textarea name="desc" rows="2"></textarea>
                        <label for="location">Locatie</label>
                        <input type="text" name="location" id="location" readonly>
                        <div id="map"></div>
                        <button type="submit" name="creCom">Verzenden</button>
                    </form> 
                </section>            
            ';
        }
    }

    // Webpage Content Generator (Admin)
    function buildManager($complaintsData, $userData) {
        echo "
            <section id='account'>
                <h2>Account Paneel</h2>
                <p>Wijzig of verwijder je eigen account.</p>

                <form action='config/account.conf.php' method='post'>
                    <input type='hidden' name='ID' value='{$userData['ID']}'>
                    <label for='uid'>Gebruikersnaam</label>
                    <input type='text' name='uid' value='{$userData['Gebruikersnaam']}'> 
                    <label for='email'>Email</label>
                    <input type='text' name='email' value='{$userData['Email']}'>
                    <label for='pwd'>Wachtwoord</label>
                    <input type='password' name='pwd'>
                    <label for='pwdRepeat'>Herhaal Wachtwoord</label>
                    <input type='password' name='pwdRepeat'>
                    
                    <input type='submit' name='updAcc' value='Wijzigen'>
                    <input type='submit' name='delAcc' value='Account Sluiten'>
                </form>
            </section>";
        echo '
            <section id="admin" class="hidden">
                <h2>Klachten Paneel</h2>
                <p>Klik op een markering om een klacht te bekijken.</p>
                <table><thead><tr>
        ';
        // Display column names as table headers
        foreach ($complaintsData['columns'] as $column) {
            echo "<th>$column</th>";
        }
        echo '</tr></thead><tbody>';
        // Display complaint data as table rows
        $counter = 0; // Initialize counter
        echo '</tr></tbody></table>
                <div style="max-height: 400px; overflow-y: auto;">
                    <table><tbody>';
        foreach ($complaintsData['klachten'] as $complaint) {
            if ($counter < 6) { // Limit to the first 6 results
                echo '<tr>';
                foreach ($complaint as $data) {
                    echo "<td>$data</td>";
                }
                echo '</tr>';
                $counter++;
            } else {
                break; // Break out of the loop once 6 iterations are done
            }
        }
        echo '</tbody></table>
                </div>
                <div id="kiezen">
                    <form id="quickSearch" method="post">
                        <label for="zoekbalk">Snelzoekfunctie:</label>
                        <select name="zoekbalk" id="zoekbalk" onchange="submitForm()">
                            <option value="default" selected>Selecteer een klacht...</option>';
        // Display complaint data as table rows
        foreach ($complaintsData['klachten'] as $complaint) {
            echo "<option name='zoekbalk' value='{$complaint['ID']}'>{$complaint['Klacht']}</option>";
        }                             
        echo '</select>
            </form>
            </div>
            <div id="map"></div>
            <div id="displayArea" class="complaint-card hidden">
                <h3></h3>
                <span></span>
                <span></span>
                <p></p>
            </div>
        </section>';                          
    }