<!doctype html>
<html lang="en">
    <head>
        <title>Reset Password Form</title>
    </head>
    <body>
        <div class="container">
            <h2>Reset New Password Here</h2>
            
            <?php
                if($_GET['email'] && $_GET['token']) {
                    require_once __DIR__ . '/../../../private/config.php';
                    $email = $_GET['email'];
                    $token = $_GET['token'];
$query = mysqli_query($conn, "SELECT * FROM `users` WHERE `reset_link_token`='".$token."' and `email`='".$email."';");
$current_date = date("Y-m-d H:i:s");
if (mysqli_num_rows($query) > 0) {
$row = mysqli_fetch_array($query);
if($row['expiry_date'] >= $current_date) { ?>
                            <form action="update-password.php" method="post">
                                <input type="hidden" name="email" value="<?php echo $email; ?>">
                                <input type="hidden" name="reset_link_token" value="<?php echo $token; ?>">
                                <div class="form-group">
                                    <label for="new-password">Password</label>
                                    <input type="password" name="password" id="new-password">
                                </div>                
                                <div class="form-group">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm-password">
                                </div>
                                <input type="submit" name="submit" class="submit-btn">
                            </form>
                        <?php } 
                    } else {
                        echo "<p>This forget password link has been expired</p>";
                    }
                }
            ?>
        </div>
    <?php include '../footer.php'; ?>
    </body>
</html>