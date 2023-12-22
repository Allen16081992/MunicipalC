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
                    <li><a href="#" data-section="logout">Uitloggen</a></li>
                </ul>
            ';                   
        }
    }

    function buildSections() {
        if (!isset($_SESSION['gebruiker_id'])) {
            echo '
                <section id="home">
                    <h2>Welkom, Hoe kunnen wij u helpen?</h2>
                    <p>Hier kunt u terecht met eventuele klachten en opmerkingen over uw omgeving.</p>
                    <button data-section="complaints">Ik wil iets melden</button>
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
                    <h2>Melding Maken</h2>
                    <!-- Complaints form goes here -->
                    <form action="config/complaint.conf.php" method="post">
                        <label for="name">Volledige Naam</label>
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
        foreach ($complaintsData['klachten'] as $complaint) {
            $counter = 0; // Initialize counter
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
        echo '</tbody></table>';

        echo '</tr></tbody></table>
            <div id="kiezen">
                <form id="quickSearch" method="post">
                    <label for="zoekbalk">Snelzoekfunctie:</label>
                    <select name="zoekbalk" id="zoekbalk" onchange="submitForm()">
                        <option value="default" selected>Selecteer een klacht...</option>';
                    // Display complaint data as table rows
                    foreach ($complaintsData['klachten'] as $complaint) {
                        echo "<option name='zoekbalk' value='{$complaint['ID']}'>{$complaint['Klacht']}</option>";
                    }                             
        echo '      </select>
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