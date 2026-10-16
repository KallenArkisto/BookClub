<?php
    if(isset($_POST['confirm_password']) && $_POST['reset_link_token'] && $_POST['email']) {
        include "dbconnection.php";
        $password = md5($_POST['confirm_password']);
        $token = $_POST['reset_link_token'];
        $email = $_POST['email'];
$query = mysqli_query($conn,"SELECT * FROM `users` WHERE `reset_link_token`='".$token."' and `email`='".$email."'");
        $row = mysqli_num_rows($query);
if($row){
            mysqli_query($conn,"UPDATE users set  password='" . $password . "', reset_link_token='" . NULL . "', expiry_date='" . NULL . "' WHERE email='" . $email . "'");
            echo '<p>Your password has been updated successfully.</p>';
        } else {
            echo "<p>Something wrong. Please try again.</p>";
        }
    }
?>