<?php
include('connection.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $feedback_text = $_POST['feedback_text'];

    
    $insert_query = "INSERT INTO feedback (full_name, phone_number, feedback_text) VALUES ('$full_name', '$phone_number', '$feedback_text')";
    $result = mysqli_query($conn, $insert_query);

    if ($result) {
        echo '<script>alert("Feedback submitted successfully!");</script>';
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fdbk.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="wrap">
        <form action="" method="post">
            <h1>FEEDBACK FORM</h1><br>
            <label>FULL - NAME</label>
            <input type="text" name="full_name" class="txt" required><br>
            <label>MO. NUMBER</label>
            <input type="number" name="phone_number" class="txt" required><br>
            <label>ADD FEEDBACK</label>
            <textarea name="feedback_text" class="abc" required></textarea><br>
            <button type="submit" class="btn">SEND FEEDBACK</button>
        </form>
    </div>
</body>
</html>
