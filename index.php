<?php // Dhr. Allen Pieter
  // Start a session for handling data, content and error messages.
  require_once 'config/include/session_manager.inc.php'; 
  // Call the periodic session rebuilder (to tackle session hijacking)
  sessionRebuild();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Gemeente Havenburg</title>
  <!-- Favicon -->
  <?php include_once 'config/include/favicon.inc.php';?>
  <!-- CSS -->
  <link rel="stylesheet" href="css/trongate.css">
  <link rel="stylesheet" href="css/styles.css">
  <!-- Include Leaflet from CDN -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script defer src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script defer src="config/js/snelzoekfunctie.js"></script>
</head>

<body>
  <header>
    <div class="logo-container">
      <a href="index.php"><img src="img/logo-hb.png" height="50" alt="Brand Signature"></a>
    </div>
    <nav>
      <?php buildHeader(); ?>
    </nav>
  </header>

  <main id="content-container">
    <?php 
      include_once 'config/include/server_messages.inc.php';
      if (!isset($_SESSION['gebruiker_id']) && !isset($_SESSION['gebruiker_naam'])) {
        buildSections(); 
      } else {
        require_once 'config/viewComplaints.conf.php';

        if ($complaintsData) {
            // Here, you can use the data, for example, with the buildManager function
            buildManager($complaintsData, $userData);
        } else { echo "Geen klachten gevonden."; }
      }
    ?>
  </main>

  <script defer src="config/js/map.js"></script>
  <script defer src="config/js/spa.js"></script>
</body>
</html>