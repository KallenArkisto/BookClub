<!-- Display all contact messages to admin -->
<?php
session_start();

// this page can only be accessed by the admin, if the user is not an admin, redirect them to the index page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
    header("location: ../index.php");
    exit;
}

// fetch all contact messages from the database
require_once __DIR__ . '/../../../private/config.php';
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <div class="container py-5">
      <h1 class="display-5 fw-bold">admin panel - Contact Messages</h1>
      <p class="lead">view all contact messages sent by users.</p>
    <table class="table ">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $message): ?>
          <tr>
            <td><?php echo htmlspecialchars($message['name']); ?></td>
            <td><?php echo htmlspecialchars($message['email']); ?></td>
            <td class="text-wrap w-auto"><?php echo htmlspecialchars($message['message']); ?></td>
            <td><?php echo $message['created_at']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?php include '../footer.php'; ?>
  </body>
</html>