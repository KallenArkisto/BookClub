<?php
session_start();
require_once __DIR__ . '/../../../private/config.php';

// this page can only be accessed by the admin, if the user is not an admin, redirect them to the index page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
    header("location: ../index.php");
    exit;
}
$events = [];

// Fetch events from the database
$sql = "SELECT * FROM events ORDER BY event_date ASC";

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
    <title>admin - Events - Bookclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles.css" />
  </head>
  <body class="bg-image">
    
  <?php include 'adminNavbar.php'; ?>

    <div class="container  py-5">
      <h1 class="display-5 fw-bold">admin panel - Events</h1>
      <p class="lead">edit and create events.</p>
    </div>

    <!--Print event information in a foreach loop-->
    
      <?php foreach($events as $event): ?>
        <div class="container  py-2 border-white border rounded bg-black bg-opacity-75 mb-2">

            <!-- visibiiy togggle radio, events table contains a column for visibility : visible/hidden. this radio should synchronize with the database value -->

            <!-- if database value is 'visible' then check the first radio button, otherwise check the second -->

            <div class="btn-group-vertical" id="vbtn-radio<?php echo $event['id']; ?>" role="group" aria-label="Vertical radio toggle button group">

                <input onclick="updateEventVisibility(<?php echo $event['id']; ?>, 'visible')"
                 type="radio" class="btn-check" name="vbtn-radio<?php echo $event['id']; ?>" id="vbtn-radio1<?php echo $event['id']; ?>" autocomplete="off" <?php echo ($event['visibility'] === 'visible') ? 'checked' : ''; ?>>

                <label class="btn btn-outline-success" for="vbtn-radio1<?php echo $event['id']; ?>">visible</label>

                <input onclick="updateEventVisibility(<?php echo $event['id']; ?>, 'hidden')"
                 type="radio" class="btn-check" name="vbtn-radio<?php echo $event['id']; ?>" id="vbtn-radio2<?php echo $event['id']; ?>" autocomplete="off" <?php echo ($event['visibility'] === 'hidden') ? 'checked' : ''; ?>>

                <label class="btn btn-outline-danger" for="vbtn-radio2<?php echo $event['id']; ?>">Hidden</label>    
            </div>
            

          <h2><?php echo htmlspecialchars($event['event_name'] ?? ''); ?></h2>
          <p>Date: <?php echo htmlspecialchars($event['event_date'] ?? ''); ?></p>
          <p>Description: <?php echo htmlspecialchars($event['description'] ?? ''); ?></p>

<!-- // print a list of all members who have registered for this event, and a button to unregister them from the event.
 The button will send an AJAX request to unregisterFromEvent.php with the member_id and event_id as parameters. -->

            <h3>Registered Members</h3>
            <?php
            $sql = "SELECT m.id, m.username FROM members m JOIN eventsignup es ON m.id = es.member_id WHERE es.event_id = :event_id";
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(":event_id", $event['id'], PDO::PARAM_INT);
                if($stmt->execute()){
                    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if(count($members) > 0){
                        echo "<ul>";
                        foreach($members as $member){
                            echo "<li>" . htmlspecialchars($member['username']) . " <button onclick=\"unregisterMemberFromEvent(" . $member['id'] . ", " . $event['id'] . ")\" class=\"btn btn-danger btn-sm\">Unregister</button></li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No members have registered for this event.</p>";
                    }
                }
                unset($stmt);
            }
            ?>

            <!-- unregister a member from an event -->
            <script>
                function unregisterMemberFromEvent(memberId, eventId) {
                    fetch('unregisterMemberFromEvent.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'member_id=' + encodeURIComponent(memberId) + '&event_id=' + encodeURIComponent(eventId)
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload(); // Reload the page to update the list of registered members
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
                function updateEventVisibility(eventId, visibility) {
                fetch('updateEventVisibility.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'event_id=' + encodeURIComponent(eventId) + '&visibility=' + encodeURIComponent(visibility)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Visibility update failed');
                        }
                        return response.text();
                    })
                    .then(data => console.log(data))
                    .catch(error => console.error('Error:', error));
                }
                
            </script>
          
          </div>
      <?php endforeach; ?>

    


        <?php include '../footer.php'; ?>
    </body>
</html>
