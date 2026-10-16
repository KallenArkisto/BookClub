<?php
session_start();
require_once __DIR__ . '/../../../private/config.php';

// this action can only be accessed by the admin, if the user is not an admin, redirect them to the index page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
    header("location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

    if ($user_id !== false && $user_id !== null) {
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare("DELETE FROM eventsignup WHERE member_id = :member_id");
            $stmt->execute([":member_id" => $user_id]);

            $stmt = $pdo->prepare("DELETE FROM members WHERE id = :id");
            $stmt->execute([":id" => $user_id]);
            $pdo->commit();
        } catch (PDOException $exception) {
            $pdo->rollBack();
            throw $exception;
        }
    }

    header("Location: profiles.php");
    exit;
}
?>