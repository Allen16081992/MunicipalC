<?php // Loubna Faress
        require_once 'secure-db.class.php'; 
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        
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
            try {
                $query = $this->connect()->prepare("DELETE FROM gebruikers WHERE ID = :ID");
                $query->bindParam(':ID', $this->ID);
                $query->execute();
                echo "Gebruiker met ID " . $this->ID . " is verwijderd.\n";
            } catch (PDOException $e) {
                echo "Fout bij het verwijderen van de gebruiker: " . $e->getMessage();
            }
        }
        

        // Functie om alle gebruikersgegevens weer te geven
        public function displayUserInfo() {
            echo "Gebruikersinformatie:\n";
            echo "gebruikers-ID: " . $this->ID . "\n";
            // echo "gebruikersnaam: " . $this->Gebruikersnaam . "\n";
            echo "E-mailadres: " . $this->Email . "\n";
            // Let op: Wachtwoord wordt niet weergegeven om beveiligingsredenen
        }
    }

    
    // $user = new User($ID, $Naam, $Wachtwoord, $Email);
    // $user->displayUserInfo();

    // Update van gebruikersgegevens
    // $user->updateEmail('');
    // $user->updateWachtwoord('nieuw_wachtwoord');

    // Gebruiker verwijderen
    // $user->deleteUser();
    
    if(isset($_POST["opslaan"])) {
        // Verwerk het bijwerken van gebruikersgegevens
        $Naam = $_POST["uid"];
        $Email = $_POST["email"];
        $Wachtwoord = $_POST["pwd"];
        $pwdRepeat = $_POST["pwdRepeat"];
    
        // Voer hier de logica uit om gebruikersgegevens bij te werken
        // Maak een object van de User-klasse en roep de update-methoden aan
        // Bijvoorbeeld:
        $user = new User($ID, $Naam, $Wachtwoord, $Email);
        $user->updateEmail($Email);
        $user->updateWachtwoord($Wachtwoord);
    } elseif (isset($_POST["verwijder"])) {
    }
?>