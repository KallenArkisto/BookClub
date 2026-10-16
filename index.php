<?php
session_start();
require_once __DIR__ . '/../../private/config.php';
//this path is the correct one for the server this page will be hosted on

$events = [];

// Fetch events from the database, that have not been marked hidden, and order them by date ascending
$sql = "SELECT * FROM events WHERE visibility != 'hidden' ORDER BY event_date ASC";

if($stmt = $pdo->prepare($sql)){
    if($stmt->execute()){
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($stmt);
}

// check if the user is admin, if yes, display the admin panel link
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["role"] === "admin"){
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Starry river Bookclub</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body class="bg-image">
     <?php include 'navbar.php'; ?>

    <div class="container py-5">
      <h1 class="display-5 fw-bold">Starry river Bookclub</h1>
      <p class="lead">Welcome to the club!</p>

<!-- link button to about page and events page -->
      <a href="about.php" class="btn btn-primary" >Learn about our community</a>
      <div class="container row p-auto m-auto">
        <div class="card bg-dark text-white col m-3">
          <div class="card-body">
            <h5 class="card-title">About us</h5>
            <p class="card-text">Learn more about our bookclub and the community we are building.</p>
          </div>
        </div>
      </div>

      
      

      <a href="events.php" class="btn btn-primary">View Coming events</a>
      <div class="container row p-auto m-auto">
          <!-- print the next 3 upcoming events only show events that have yet to occur -->
          <?php
          $sql = "SELECT * FROM events WHERE visibility != 'hidden' AND event_date > NOW() ORDER BY event_date ASC LIMIT 3";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $upcomingEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          foreach($upcomingEvents as $row) {
              echo "<div class='card bg-dark text-white col m-3'>";
              echo "<div class='card-body'>";
              echo "<h5 class='card-title'>" . htmlspecialchars($row["event_name"]) . "</h5>";
              echo "<p class='card-text'>" . htmlspecialchars($row["description"]) . "</p>";
              echo "<p class='card-text align-bottom'>Date: " . htmlspecialchars($row["event_date"]) . "</small></p>";
              echo "</div>";
              echo "</div>";
          }
          ?>
      </div><!-- contact us page link -->
      <a href="contact.php" class="btn btn-primary">Contact Us</a>
      <div class="container row p-auto m-auto">
        <div class="card bg-dark text-white col m-3">
          <div class="card-body">
            <h5 class="card-title">Any questions?</h5>
            <p class="card-text">Get in touch with us to learn more about our bookclub.</p>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <?php include 'footer.php'; ?>
  </body>
</html>
