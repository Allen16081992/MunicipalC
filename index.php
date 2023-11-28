<?php // Dhr. Allen Pieter
  // Start a session for handling data, content and error messages.
  require_once 'config/include/session_manager.inc.php'; 
  
  // Call the periodic session rebuilder (to tackle session hijacking)
  sessionRebuild(); 

  // Load PHP files to retrieve data
    //require_once "config/ViewResumes.config.php";
    //require_once "config/FetchResumeTables.config.php";
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
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>

<body>
  <header>
    <div class="logo-container">
      <a href="index.php"><img src="img/MunicCrest.png" height="40" alt="Brand Signature"></a>
    </div>
    <h1>Gemeente Havenburg</h1>

    <nav>
      <?php buildHeader(); ?>
    </nav>
  </header>

  <main id="content-container">
    <?php 
      include_once 'config/include/server_messages.inc.php';
      if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name'])) {
        buildSections(); 
      }
      if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
        require_once 'config/viewComplaints.conf.php';

        try {
            $dbFetcher = new DbFetcher();
            $complaintsData = $dbFetcher->fetchComplaints();
        
            if ($complaintsData) {
                // Here, you can use the data, for example, with the buildManager function
                buildManager($complaintsData);
            } else {
                echo "No complaint data found.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        
        buildManager();
      }
    ?>
  </main>

  <script defer src="config/js/map.js"></script>
  <script defer src="config/js/spa.js"></script>
</body>
</html>