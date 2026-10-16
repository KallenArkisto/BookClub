<?php
session_start();
require_once __DIR__ . '/../../private/config.php';

function registerForEvent(PDO $pdo, int $event_id): void
{
    $member_id = $_SESSION["id"];
    $sql = "INSERT INTO eventsignup (member_id, event_id) VALUES (:member_id, :event_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":member_id", $member_id, PDO::PARAM_INT);
    $stmt->bindParam(":event_id", $event_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "You have successfully registered for the event.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["event_id"])) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        http_response_code(401);
        echo "Please log in to register for an event.";
        exit;
    }

    registerForEvent($pdo, (int) $_POST["event_id"]);
}
?>