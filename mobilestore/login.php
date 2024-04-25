<?php

include("header.php");
require('connection.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check_email = "SELECT * FROM user WHERE email='$email'";
    $run_email = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($run_email) > 0) {
        $row_email = mysqli_fetch_array($run_email);
        $db_id = $row_email['id'];
        $db_name = $row_email['username'];
        $db_type = $row_email['type'];
        $db_email = $row_email['email'];
        $db_password = $row_email['password'];

        if ($email == $db_email && $password == $db_password && $db_type == 'user') {
            $_SESSION['id'] = $db_id; 
            $_SESSION['user_email'] = $db_email;
            $_SESSION['username'] = $db_name;
            $_SESSION['user_type'] = $db_type;
            $_SESSION['ulogged_in'] = true;
            header("Location: index.php"); 
            exit();
        } elseif ($email == $db_email && $password == $db_password && $db_type == 'admin') {
            $_SESSION['admin_email'] = $db_email;
            $_SESSION['admin_name'] = $db_name;
            $_SESSION['admin_type'] = $db_type;
            $_SESSION['alogged_in'] = true;
            header("Location: admin/index.php"); 
            exit();
        } else {
            $login_error = "Username or Password is Wrong"; 
        }
    } else {
        $login_error = "No Email Found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>LOGIN NOW</h3>
            <input type="email" name="email" placeholder="Enter email" class="box">
            <input type="password" name="password" placeholder="Enter password" class="box">
            <input type="submit" name="login" class="btn" value="Login">
            <p>Don't have an account? <a href="signup.php">Sign up now</a></p>
            <p>forgot password ? <a href="forgotpass.php">reset pass</a></p>
        </form>
        <?php
        if (isset($login_error)) {
            echo "<p>$login_error</p>";
        }
        ?>
    </div>
</body>
</html>
