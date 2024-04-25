<?php
include("header.php");
include('connection.php');

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit;
}

$userId = $_SESSION['id'];

if (isset($_POST['delete_item'])) {
    $cartIdToDelete = $_POST['delete_item'];
    $deleteQuery = "DELETE FROM cart WHERE cart_id = $cartIdToDelete AND user_id = $userId";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        echo 'Error deleting item: ' . mysqli_error($conn);
    }
}

if (isset($_POST['cancel_order'])) {
    $clearCartQuery = "DELETE FROM cart WHERE user_id = $userId";
    $clearCartResult = mysqli_query($conn, $clearCartQuery);

    if ($clearCartResult) {
        echo 'Order cancelled and cart cleared!';
    } else {
        echo 'Failed to cancel order: ' . mysqli_error($conn);
    }
}

$sql = "SELECT cart.*, products.name, products.price, products.image FROM cart 
        INNER JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $userId";

$result = mysqli_query($conn, $sql);

$cartItems = array();
$totalBill = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
        $totalBill += ($row['price'] * $row['quantity']);
    }
}

$orderHistory = array();
$orderHistoryQuery = "SELECT * FROM orders WHERE user_id = $userId";

$orderHistoryResult = mysqli_query($conn, $orderHistoryQuery);

if ($orderHistoryResult && mysqli_num_rows($orderHistoryResult) > 0) {
    while ($orderRow = mysqli_fetch_assoc($orderHistoryResult)) {
        $orderHistory[] = $orderRow;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            background-color: darkslategrey;
        }
        .one{
            position: absolute;
            top:50%;
            left:50%;
            transform: translate(-50%,-50%);
            background-color: orange;
            padding:40px;
            border-radius: 40px;
          
          }
    </style>
</head>
<body>
    <div class="one">
    <h1>User's Cart</h1>
    <br>
    <form method="post">
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($cartItems as $cartItem) {
                    echo '<tr>';
                    echo '<td>' . $cartItem['product_id'] . '</td>';
                    echo '<td>' . $cartItem['name'] . '</td>';
                    echo '<td>' . $cartItem['price'] . '</td>';
                    echo '<td>' . $cartItem['quantity'] . '</td>';
                    echo '<td><img src="admin/img/' . $cartItem['image'] . '" height="50px"></td>';
                    echo '<td><button type="submit" name="delete_item" value="' . $cartItem['cart_id'] . '">Delete</button></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
<br>
        <p>Total Bill: $<?php echo $totalBill; ?></p><br><br>
        <h2>Confirm Order</h2><br>
        <a href="order_confirmation.php">Confirm Order</a>
        <button type="submit" name="cancel_order">Cancel Order</button>
    </form>
    <br><br>

    <h2>Order History</h2><br>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Total Amount</th>
                <th>Address</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($orderHistory as $order) {
                echo '<tr>';
                echo '<td>' . $order['id'] . '</td>';
                echo '<td>' . $order['order_date'] . '</td>';
                echo '<td>' . $order['name'] . '</td>';
                echo '<td>' . $order['contact_details'] . '</td>';
                echo '<td>$' . $order['total_amount'] . '</td>';
                echo '<td>' . $order['address'] . '</td>';
                echo '<td>' . $order['status'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
        </div>
    </table>
</body>
</html>
