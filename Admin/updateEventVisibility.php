<?php
session_start();
require_once __DIR__ . '/../../../private/config.php';

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
    http_response_code(403);
    exit('Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$event_id = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);
$visibility = $_POST['visibility'] ?? '';

if ($event_id === false || $event_id === null || !in_array($visibility, ['visible', 'hidden'], true)) {
    http_response_code(400);
    exit('Invalid event visibility data');
}

$sql = "UPDATE events SET visibility = :visibility WHERE id = :event_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt->bindValue(':visibility', $visibility, PDO::PARAM_STR);
$stmt->execute();

echo 'Event visibility updated successfully.';
