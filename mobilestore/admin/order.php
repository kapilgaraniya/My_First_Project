<?php
include("config.php");

$ordersQuery = "SELECT * FROM orders";
$ordersResult = mysqli_query($conn, $ordersQuery);

if (isset($_POST['cancel'])) {
    $orderIdToCancel = $_POST['order_id'];
    $updateStatusQuery = "UPDATE orders SET status = 'cancelled' WHERE id = $orderIdToCancel";
    $updateStatusResult = mysqli_query($conn, $updateStatusQuery);

    if (!$updateStatusResult) {
        echo 'Error cancelling order: ' . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link rel="stylesheet" href="order.css">
    <style>
        body{
            background-color: grey;
        }
    .order-container{
        position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: brown;
    border-radius: 50px;
    

    }
    .rrr{
        padding: 30px ;
    }
    h1{
        color: blue;
        display: flex;
        align-items: center;
        justify-content: center;
        
      }
    </style>
</head>
<body>
    <?php include 'index.php'; ?>

    <div class="order-container">
        <h1>Order List</h1>
        <div class="rrr">
        <table border=1>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>name</th>
                <th>Address</th>
                <th>Contact Details</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($order = mysqli_fetch_assoc($ordersResult)) {
                echo '<tr>';
                echo '<td>' . $order['id'] . '</td>';
                echo '<td>' . $order['user_id'] . '</td>';
                echo '<td>' . $order['order_date'] . '</td>';
                echo '<td>$' . $order['total_amount'] . '</td>';
                echo '<td>' . $order['name'] . '</td>';
                echo '<td>' . $order['address'] . '</td>';
                echo '<td>' . $order['contact_details'] . '</td>';
                echo '<td>' . $order['status'] . '</td>';
                echo '<td>';
                if ($order['status'] === 'pending') {
                    echo '<form action="confirm_order.php" method="post">';
                    echo '<input type="hidden" name="order_id" value="' . $order['id'] . '">';
                    echo '<input type="submit" name="confirm" value="Confirm">';
                    echo '</form>';
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="order_id" value="' . $order['id'] . '">';
                    echo '<input type="submit" name="cancel" value="Cancel Order">';
                    echo '</form>';
                } elseif ($order['status'] === 'completed') {
                    echo 'Completed';
                } else {
                   //run
                }
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
    </div>
</body>
</html>
