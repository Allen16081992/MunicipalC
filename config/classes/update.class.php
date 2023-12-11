<?php // Loubna Faress
        require_once 'secure-db.class.php';    
        
    class User extends Database {
        private $ID;
        private $Naam;
        private $Wachtwoord;
        private $Email;

        public function __construct($ID, $Naam, $Wachtwoord, $Email) {
            $this->ID = $ID;
            $this->Naam = $Naam;
            $this->Wachtwoord = $Wachtwoord;
            $this->Email = $Email;
        }

        // functie om de email bij te werken
        public function updateEmail($newEmail) {
            $this->Email = $newEmail;
            echo "E-mailadress bijgewerkt naar:" . $this->Email . "\n";
        }

        // functie om het wachtwoord bij te werken
        public function updateWachtwoord($newWachtwoord) {
            // Hier zou normaal gesproken logica zijn om het wachtwoord in de database bij te werken
            // Voor dit voorbeeld wordt de waarde gewoon bijgewerkt
            $this->Wachtwoord = $newWachtwoord;
            echo "wachtwoord is bijgewerkt\n";
        }

        // Functie om een gebruiker te verwijderen
        public function deleteUser() {
        $query = $this->connect()->prepare("DELETE FROM gebruikers WHERE ID = :ID");
        $query->bindParam(':ID', $this->ID);
        $query->execute();
        echo "Gebruiker met ID " . $this->ID . " is verwijderd.\n";
        }

        // Functie om alle gebruikersgegevens weer te geven
        public function displayUserInfo() {
            echo "Gebruikersinformatie:\n";
            echo "gebruikers-ID: " . $this->ID . "\n";
            echo "gebruikersnaam: " . $this->Gebruikersnaam . "\n";
            echo "E-mailadres: " . $this->Email . "\n";
            // Let op: Wachtwoord wordt niet weergegeven om beveiligingsredenen
        }
    }

    // Voorbeeldgebruik:
    $user = new User(1, 'voorbeeldgebruiker', 'voorbeeld@email.com', 'wachtwoord123');
    $user->displayUserInfo();

    // Update van gebruikersgegevens
    $user->updateEmail('nieuw@email.com');
    $user->updateWachtwoord('nieuw_wachtwoord');

    // Gebruiker verwijderen
    $user->deleteUser();
    
    if(isset($_POST["submit"])) {

            $Naam = $_POST["uid"];
            $Email = $_POST["email"];
            $Wachtwoord = $_POST["pwd"];
            $pwdRepeat = $_POST["pwdRepeat"];
        }
?>