<!-- Include Leaflet from CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styles.css">
  <title>Home | Gemeente Havenburg</title>
  <!-- Favicon -->
  <?php include_once 'config/include/favicon.php';?>
  <style>
        #map {
            height: 400px;
            width: 50%;
            margin:20px;
            border-radius: 15px;
            border-width: 5px;
            border-style: solid;
            border-color: silver;
        }
    </style>
</head>

<body>
  <header>
    <div class="logo-container">
      <a href="index.php"><img src="img/MunicCrest.png" height="40" alt="Brand Signature"></a>
    </div>
    <h1>Gemeente Havenburg</h1>
    <nav>
      <ul>
        <?php if(!isset($_SESSION['user_id'])) { ?>
            <li><a href="#" data-section="home">Home</a></li>
            <li><a href="#" data-section="login">Inloggen</a></li>
            <li><a href="#" data-section="signup">Registreren</a></li>
            <li><a href="#" data-section="complaints">Melding Maken</a></li>
        <?php } else {
            echo '
                <li><a class="current">'.$_SESSION['user_name'].'</a></li>
                <li><a href="#" data-section="manage">Management</a></li>
                <li><a href="logout.php">Logout</a></li>
            ';
        } ?>
      </ul>
    </nav>
  </header>

  <main id="content-container">
    <section id="home">
      <h2>Welcome to Gemeente Havenburg</h2>
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

  <script>
        var map = L.map('map').setView([0, 0], 14); // Initial view at (0, 0)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        document.getElementById('track-form').addEventListener('submit', function (e) {
            e.preventDefault();
            var latitude = parseFloat(document.getElementById('latitude').value);
            var longitude = parseFloat(document.getElementById('longitude').value);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                if (marker) {
                    marker.setLatLng([latitude, longitude]).update();
                } else {
                    marker = L.marker([latitude, longitude]).addTo(map);
                }

                map.setView([latitude, longitude], 14);
            } else {
                alert('Please enter valid coordinates.');
            }
        });
  </script>
  <script defer src="config/js/spa.js"></script>
</body>
</html>