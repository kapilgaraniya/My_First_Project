<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Signup</title>

   <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<div class="form-container">
   <form action="" method="post">
      <h3>SIGN-UP NOW</h3>
      <input type="text" name="username"  placeholder="Enter username" class="box" required>
      <div>
        <label for="user_dob">Date of Birth:</label>
        <input type="date"  name="user_dob" required>
        </div>
      <input type="email" name="email" placeholder="Enter email" class="box" required>
      <input type="password" name="password"  placeholder="Enter password" class="box" required>
      <input type="submit" name="signup" class="btn" value="Signup">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
   <?php
   include("connection.php");

   if (isset($_POST['signup'])) {
       $username = $_POST['username'];
       $userDOB = $_POST['user_dob'];
       $email = $_POST['email'];
       $password = $_POST['password'];

        $checkQuery = "SELECT id FROM user WHERE username='$username' OR email='$email'";
        $result = mysqli_query($conn, $checkQuery);
 
        if (mysqli_num_rows($result) > 0) {
            echo "Username or email already exists.";
        } else {

       $sql = "INSERT INTO user (username,user_dob, email, password, type) VALUES ('$username','$userDOB', '$email', '$password', 'user')";
       $result = mysqli_query($conn, $sql);

       if ($result) {
           echo "Registration successful!";
       } else {
           echo "Error: " . mysqli_error($conn);
       }
   }}
   ?>
</div>

</body>
</html>
