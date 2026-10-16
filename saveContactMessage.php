<?php
require_once __DIR__ . '/../../private/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: contact.php');
	exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	header('Location: contact.php?status=invalid');
	exit;
}

$sql = 'INSERT INTO messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())';
$stmt = $pdo->prepare($sql);
$stmt->execute([$name, $email, $message]);

header('Location: contact.php?status=sent');
exit;
