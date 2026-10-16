<?php
session_start();
require_once __DIR__ . '/../../private/config.php';
$events = [];

// Fetch events from the database, that have not been marked hidden, and order them by date ascending
$sql = "SELECT * FROM events WHERE visibility != 'hidden' ORDER BY event_date ASC";

if($stmt = $pdo->prepare($sql)){
    if($stmt->execute()){
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($stmt);
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events - Bookclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body class="bg-image">
    
  <?php include 'navbar.php'; ?>

    <div class="container py-5">
      <h1 class="display-5 fw-bold">Upcoming Events</h1>
      <p class="lead">Here you can see the book club events.</p>
    </div>

    <!--Print event information in a foreach loop-->
    
      <?php foreach($events as $event): ?>
        <div class="container py-5 border-white bg-black bg-opacity-75 border rounded">
          <h2><?php echo htmlspecialchars($event['event_name'] ?? ''); ?></h2>
          <p>Date: <?php echo htmlspecialchars($event['event_date'] ?? ''); ?></p>
          <p>Description: <?php echo htmlspecialchars($event['description'] ?? ''); ?></p>


            <!--only logged in users can register for the event, guests on see a greyed out button -->
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
           <div>
            <p class="text">extra services such as refresments and snacks are provided to all members</p>
             </div>
          
        

          <button id="registerBtn(<?php echo $event['id']; ?>)" onclick="registerForEvent(<?php echo $event['id']; ?>)" class="btn btn-primary">Register for Event</button>
          <!-- if the member has already registered disable the button -->

          
          
          
        <!--if the user is already registered from the event, show a message beside of the button-->
          <?php
          $member_id = $_SESSION["id"];
          $event_id = $event['id'];
          $sql = "SELECT * FROM eventsignup WHERE member_id = :member_id AND event_id = :event_id";
          if($stmt = $pdo->prepare($sql)){
              $stmt->bindParam(":member_id", $member_id, PDO::PARAM_INT);
              $stmt->bindParam(":event_id", $event_id, PDO::PARAM_INT);
              if($stmt->execute()){
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  if($result){
                    // Disable the register button
                    echo "<script>document.getElementById('registerBtn(" . $event['id'] . ")').disabled = true;</script>";
                    echo "<p class='badge text-bg-success'>You have been registered for this event.</p>";
                    
                    // Show a badge that says "You have been registered for this event."
                    
                  }
              }
              unset($stmt);
          }
        ?>
        <br>
        <!--then, show a button that says "Unregister from Event" and when clicked, it will remove the member from the eventsignup table for that event.-->
        <button onclick="unregisterFromEvent(<?php echo $event['id']; ?>)" class="btn btn-danger">Unregister</button>
        <?php else: ?>
          <button class="btn btn-secondary" disabled>Log in to Register for Event</button>
        <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <!-- javascript function to send an AJAX request to registerForEvent.php when the button is clicked   -->
      <script>
        function registerForEvent(eventId) {
          // Send an AJAX request to registerForEvent.php
          fetch('registerForEvent.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'event_id=' + encodeURIComponent(eventId)
          })
            .then(response => response.text())
            .then(data => {
              alert(data); // Show the response from the server
              location.reload(); // Reload the page to update the registration status
            })
            .catch(error => {
              console.error('Error:', error);
            });
        }

        function unregisterFromEvent(eventId) {
          fetch('unregisterFromEvent.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'event_id=' + encodeURIComponent(eventId)
          })
            .then(response => response.text())
            .then(data => {
              alert(data);
              location.reload();
            })
            .catch(error => {
              console.error('Error:', error);
            });
        }
      </script>


    <?php include 'footer.php'; ?>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>