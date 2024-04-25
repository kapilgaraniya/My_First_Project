<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm']) && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    $updateQuery = "UPDATE orders SET status = 'completed' WHERE id = $orderId";
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: order.php");
        exit();
    } else {
        echo "Error updating order: " . mysqli_error($conn);
    }
} else {
    header("Location: order.php");
    exit();
}

mysqli_close($conn);
?>
