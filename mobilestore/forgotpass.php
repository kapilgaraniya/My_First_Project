<?php

include('connection.php');
include('header.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset-btn'])) {
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    
    $check_user = "SELECT * FROM user WHERE email='$email' AND user_dob='$birthdate'";
    $run_check_user = mysqli_query($conn, $check_user);

    if (mysqli_num_rows($run_check_user) > 0) {
        if ($newPassword === $confirmPassword) {
            
            $update_password = "UPDATE user SET password='$newPassword' WHERE email='$email'";
            $run_update_password = mysqli_query($conn, $update_password);

            if ($run_update_password) {
                $reset_success = "Password reset successful. You can now login with your new password.";
            } else {
                $reset_error = "Password reset failed.";
            }
        } else {
            $reset_error = "Passwords do not match.";
        }
    } else {
        $reset_error = "Invalid email or birthdate.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <style>
        body{
            background-color: darkslategrey;
        }
        .www{
             position: absolute;
            top:50%;
            left:50%;
            transform: translate(-50%,-50%);
            background-color: orange;
            padding: 80px;
            border-radius: 40px;
        }
        input{
            display: grid;
            place-items: center;
        }
    </style>
</head>
<body>
    <div class="www">
    <h1>Forgot Password</h1><br>
    
    <?php
    if (isset($reset_success)) {
        echo "<p>$reset_success</p>";
    } elseif (isset($reset_error)) {
        echo "<p>$reset_error</p>";
    }
    ?>
    
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" required><br><br>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required><br><br>
        <input type="submit" value="Reset Password" name="reset-btn">
    </form>
    </div>
</body>
</html>
