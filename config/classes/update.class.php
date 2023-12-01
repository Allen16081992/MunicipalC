<?php // Loubna Faress
        require_once 'secure-db.class.php';    
        
    class User extends Database {
        private $uid;
        private $password;
        private $email;

        public function __construct($uid, $password, $email) {
            $this->uid = $uid;
            $this->password = $password;
            $this->email = $email;
        }

        // functie om de email bij te werken
        public function updateEmail($newEmail) {
            $this->email = $newEmail;
            echo "E-mailadress bijgewerkt naar:" . $this->email . "\n";
        }

        // functie om het wachtwoord bij te werken
        public function updatePassword($newPassword) {
            // Hier zou normaal gesproken logica zijn om het wachtwoord in de database bij te werken
            // Voor dit voorbeeld wordt de waarde gewoon bijgewerkt
            $this->password = $newPassword;
            echo "wachtwoord is bijgewerkt\n";
        }

        // Functie om alle gebruikersgegevens weer te geven
        public function displayUserInfo() {
            echo "Gebruikersinformatie:\n";
            echo "gebruikers-ID: " . $this->id . "\n";
            echo "gebruikersnaam: " . $this->username . "\n";
            echo "E-mailadres: " . $this->email . "\n";
            // Let op: Wachtwoord wordt niet weergegeven om beveiligingsredenen
        }
    }

    // Voorbeeldgebruik:
    $user = new User(1, 'voorbeeldgebruiker', 'voorbeeld@email.com', 'wachtwoord123');
    $user->displayUserInfo();
    
    if(isset($_POST["submit"])) {

            $uid = $_POST["uid"];
            $email = $_POST["email"];
            $password = $_POST["pwd"];
            $pwdRepeat = $_POST["pwdRepeat"];
        }
?>