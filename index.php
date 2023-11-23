<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styles.css">
  <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
  <title>Dutch Municipality</title>
</head>

<body>
  <header>
    <h1>Dutch Municipality</h1>
    <nav>
      <ul>
        <?php if(!isset($_SESSION['user_id'])) { ?>
            <li><a href="#home"><img src="#" alt="Brand Signature"></a></li>
            <li><a href="#home">Home</a></li>
            <li><a href="#login">Inloggen</a></li>
            <li><a href="#signup">Registreren</a></li>
            <li><a href="#complaints">Melding Maken</a></li>
        <?php } else {
            echo '
                <li><a class="current">'.$_SESSION['user_name'].'</a></li>
                <li><a href="#manage">Management</a></li>
                <li><a href="logout.php">Logout</a></li>
            ';
        } ?>
      </ul>
    </nav>
  </header>

  <main>
    <section id="home">
      <h2>Welcome to Dutch Municipality</h2>
      <p>Explore and engage with your community.</p>
    </section>

    <section id="login" class="hidden">
      <h2>Inloggen</h2>
      <!-- Login form goes here -->
      <form action="config/login.conf.php" method="post">
        <label for="uid">Gebruiker</label><br>
        <input type="text" id="uid" name="uid"><br>
        <label for="pwd">Wachtwoord</label><br>
        <input type="password" id="pwd" name="pwd"><br>
        <input type="submit" value="Inloggen">
      </form> 
    </section>

    <section id="signup" class="hidden">
      <h2>Registreren</h2>
      <!-- Sign-up form goes here -->
      <form action="config/signup.conf.php" method="post">
        <label for="uid">Gebruiker</label><br>
        <input type="text" id="uid" name="uid"><br>
        <label for="email">Email</label><br>
        <input type="text" name="email" placeholder="E-mail"><br>
        <label for="pwd">Wachtwoord</label><br>
        <input type="password" id="pwd" name="pwd"><br>
        <label for="pwdRepeat">Herhaal Wachtwoord</label><br>
        <input type="password" name="pwdRepeat" placeholder="Repeat Password"><br><br>
        <button type="submit" name="submit">Registreren</button>
      </form> 
    </section>

    <section id="complaints" class="hidden">
      <h2>Submit Complaints</h2>
      <!-- Complaints form goes here -->
      <form action="includes/complaint.inc.php" method="post">
        <label for="name">Naam</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="surname">Achternaam</label><br>
        <input type="text" id="surname" name="surname"><br>
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email"><br>
        <label for="location">Locatie</label><br>
        <input type="text" id="location" name="location"><br><br>
        <div id="map" style = "width:500px; aspect-ratio:16/9;"></div><br>
        <input type="submit" value="Verzenden">
      </form> 
    </section>
  </main>

  <script src="config/js/spa.js"></script>
  <script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
  <script>
        // Creating map options
        var mapOptions = {
            center: [17.385044, 78.486671],
            zoom: 10
        }
        
        // Creating a map object
        var map = L.map('map').setView([51.505, -0.09], 13);
        
        // Creating a Layer object
        var layer = new L.TileLayer('http://tile.openstreetmap.org/{z}/{x}/{y}.png');

        L.marker([51.5, -0.09]).addTo(map).bindPopup('A pretty CSS popup.').openPopup();

        // Adding layer to the map
        map.addLayer(layer);
  </script>
</body>
</html>