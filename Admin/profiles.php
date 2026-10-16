<?php
session_start();
require_once __DIR__ . '/../../../private/config.php';

    // admin check
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin"){
        header("location: ../index.php");
        exit;
    }

// Fetch members using PDO
$sql = "SELECT * FROM members";
if($stmt = $pdo->prepare($sql)){
    if($stmt->execute()){
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Query failed: " . implode(", ", $stmt->errorInfo()));
    }
} else {
    die("Prepare failed: " . implode(", ", $pdo->errorInfo()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Member Profiles</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="../styles.css" />
</head>
<body class="bg-image">
  <?php include 'adminNavbar.php'; ?>
  
  <div class="container py-5">
    <h1 class="display-5 fw-bold mb-4">Member Profiles</h1>
    
    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
      <div class="mb-4">
        <a href="../manage-profile.php" class="btn btn-primary">Add New Profile</a>
      </div>
    <?php endif; ?>
    
    <div class="row">
      <?php foreach ($members as $member): ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="card bg-dark text-light h-100">
            <img src="<?php echo '../images/' . htmlspecialchars($member['profile_image'] ?? 'default-profile.png') ?>" class="card-img-top" alt="Profile" height="200">
            <div class="card-body">
              <p class="card-text">Name: <?php echo htmlspecialchars($member['username'] ?? ''); ?></p>
              <p class="card-text">Email: <?php echo htmlspecialchars($member['email'] ?? ''); ?></p>
              <p class="card-text">Bio: <?php echo htmlspecialchars($member['bio'] ?? ''); ?></p>
            </div>
            <div class="card-footer bg-transparent border-top-0">
              <!-- open a page with the following edit options: editing profile, deleting profile
               only for admins -->

              <a href="AdminEditUser.php?id=<?php echo $member['id']; ?>" class="btn btn-sm btn-primary w-100">Edit User</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <?php include '../footer.php'; ?>
</body>
</html>

<!-- muokkaa profiileja -->