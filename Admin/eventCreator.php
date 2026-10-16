<!-- this page contains the form for creating new events -->
 <!-- only accessible to admins, so check if the user is an admin before displaying the form. If not, redirect them to the index page. -->
<?php
session_start();
require_once __DIR__ . '/../../../private/config.php';

// this page can only be accessed by the admin, if the user is not an admin, redirect them to the index page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
    header("location: ../index.php");
    exit;
}


?>
<html>
  <head>
    <title>Create Event</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../styles.css" />

  </head>
  <body class="bg-image">
    <?php include 'adminNavbar.php'; ?>
    
    <div class="container py-5">
    <h1>Create Event</h1>

    <!-- Add Event Form -->
    <?php include 'addEventForm.php'; ?>

    </div>
    <?php include '../footer.php'; ?>
  </body>
</html>