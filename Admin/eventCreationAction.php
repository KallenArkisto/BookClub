<!-- Event Creation Action -->
 <!-- insert new event into the database -->
<?php
require_once __DIR__ . '/../../../private/config.php';


// this action can only be accessed by the admin, if the user is not an admin, redirect them to the index page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
    header("location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST["event_name"];
    $description = $_POST["description"];
    $event_date = $_POST["event_date"];
    

    $sql = "INSERT INTO events (event_name, description, event_date) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$event_name, $description, $event_date]);

    // then redirect to the index.php page
    header("Location: index.php");

}
?>