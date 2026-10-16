<?php
session_start();
require_once __DIR__ . '/../../../private/config.php';

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
    header("location: index.php");
    exit;
}

// get memebr_id and event_id from Post
$member_id = $_POST["member_id"];
$event_id = $_POST["event_id"];

// Function to unregister the selected member from an event

function unregisterFromEvent(PDO $pdo, int $event_id): void
{
    $member_id = $_POST["member_id"];
    $sql = "DELETE FROM eventsignup WHERE member_id = :member_id AND event_id = :event_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":member_id", $member_id, PDO::PARAM_INT);
    $stmt->bindParam(":event_id", $event_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "Successfully unregistered from the event.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["event_id"])) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        http_response_code(401);
        echo "Please log in to unregister from an event.";
        exit;
    }

    unregisterFromEvent($pdo, (int) $_POST["event_id"]);
}
?>