<?php
include('config.php');


if (isset($_POST['delete_feedback'])) {
    $feedbackIdToDelete = $_POST['delete_feedback'];
    $deleteQuery = "DELETE FROM feedback WHERE id = $feedbackIdToDelete";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        echo 'Error deleting feedback: ' . mysqli_error($conn);
    }
}

$query = "SELECT * FROM feedback ORDER BY submission_date DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo 'Error: ' . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href=".css">
    <style>

body{
            background-color: grey;
        }
.feedback-list{
    position: absolute;
    margin-top: 20%;
    left: 50%;
    transform: translate(-50%,-50%);
    font-size: 20px;
    background-color: brown;
    border-radius: 50px;
    padding: 50px;

}
td{
    padding: 20px;
}
h1{
    display: flex;
    align-items: center;
    justify-content: center;
    color:blue ;
}
    </style>
</head>
<body>
    <?php include 'index.php'; ?>

    <div class="feedback-list">
        <h1>Feedback List</h1><br>
        <table border=1>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Feedback Text</th>
                    <th>Submission Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['full_name'] . '</td>';
                    echo '<td>' . $row['phone_number'] . '</td>';
                    echo '<td>' . $row['feedback_text'] . '</td>';
                    echo '<td>' . $row['submission_date'] . '</td>';
                    
                    // Add a Delete button for each feedback entry
                    echo '<td>
                            <form method="post">
                                <button type="submit" name="delete_feedback" value="' . $row['id'] . '">Delete</button>
                            </form>
                          </td>';
                    
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
