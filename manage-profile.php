<?php
session_start();
require_once __DIR__ . '/../../private/config.php';

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];
$username = $email = $bio = $profile_image = "";
$email_err = $bio_err = $file_err = "";
$success_msg = "";

// Fetch current user profile data
$sql = "SELECT username, email, bio, profile_image FROM members WHERE id = :id";
if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
    if($stmt->execute()){
        if($row = $stmt->fetch()){
            $username = $row["username"];
            $email = $row["email"] ?? "";
            $bio = $row["bio"] ?? "";
            $profile_image = $row["profile_image"] ?? "";
        }
    }
    unset($stmt);
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate email
    if(!empty(trim($_POST["email"]))){
        $email = trim($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_err = "Please enter a valid email address.";
        }
    } else {
        $email = "";
    }
    
    // Validate bio
    if(!empty(trim($_POST["bio"]))){
        $bio = trim($_POST["bio"]);
    } else {
        $bio = "";
    }
    
    // Handle file upload
    if(!empty($_FILES["profilePicture"]["name"])){
        $target_dir = "images/";
        if(!is_dir($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        
        $file_name = basename($_FILES["profilePicture"]["name"]);
        $target_file = $target_dir . time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '', $file_name);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check file size (max 5MB)
        if($_FILES["profilePicture"]["size"] > 5000000){
            $file_err = "File is too large. Maximum size is 5MB.";
        } 
        // Check file type
        elseif(!in_array($file_type, array("jpg", "jpeg", "png", "gif"))){
            $file_err = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        } 
        // Upload file
        elseif(move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)){
            // Delete old profile image if exists
            if(!empty($profile_image) && file_exists("images/" . $profile_image)){
                unlink("images/" . $profile_image);
            }
            $profile_image = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '', $file_name);
        } else {
            $file_err = "Error uploading file. Please try again.";
        }
    }
    
    // Check if there are no errors before updating database
    if(empty($email_err) && empty($file_err)){
        
        // Prepare update statement
        $sql = "UPDATE members SET email = :email, bio = :bio";
        $params = [":email" => $email, ":bio" => $bio, ":id" => $user_id];
        
        // Only update profile_image if a new file was uploaded
        if(!empty($_FILES["profilePicture"]["name"]) && empty($file_err)){
            $sql .= ", profile_image = :profile_image";
            $params[":profile_image"] = $profile_image;
        }
        
        $sql .= " WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            if($stmt->execute($params)){
                $success_msg = "Profile updated successfully!";
            } else {
                $email_err = "Error updating profile. Please try again.";
            }
            unset($stmt);
        }
    }
    
    unset($pdo);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body class="bg-image">
    
  <?php include 'navbar.php'; ?>

    <div class="container py-5">
      <h1 class="display-5 fw-bold">Manage Profile</h1>
      <p class="lead">Update your profile information here.</p>
      
      <?php 
      if(!empty($success_msg)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $success_msg; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
    </div>
    
    <div class="container py-5">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" disabled>
              <small class="form-text text-muted">Username cannot be changed.</small>
            </div>
            
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>">
              <?php if(!empty($email_err)): ?>
                <div class="invalid-feedback"><?php echo $email_err; ?></div>
              <?php endif; ?>
            </div>
            
            <div class="mb-3">
              <label for="bio" class="form-label">Biography</label>
              <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Tell us about yourself"><?php echo htmlspecialchars($bio); ?></textarea>
            </div>

            <?php if(!empty($profile_image)): ?>
              <div class="mb-3">
                <label class="form-label">Current Profile Picture</label>
                <div>
                  <img src="images/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Picture" style="max-width: 150px; height: auto;">
                </div>
              </div>
            <?php endif; ?>
            
            <div class="mb-3">
              <label for="profilePicture" class="form-label">Update Profile Picture</label>
              <input type="file" class="form-control <?php echo (!empty($file_err)) ? 'is-invalid' : ''; ?>" id="profilePicture" name="profilePicture" accept="image/*">
              <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG, GIF (Max 5MB)</small>
              <?php if(!empty($file_err)): ?>
                <div class="invalid-feedback d-block"><?php echo $file_err; ?></div>
              <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
          </form>
        </div>
      </div>
    </div>
    <?php include 'footer.php'; ?>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
