<?php
include('connection.php');
include('header.php');

$name = $contactNumber = $address = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_order'])) {
        $name = $_POST['name'];
        $contactNumber = $_POST['contact_number'];
        $address = $_POST['address'];

    if (empty($errors)) {
        
        $userId = $_SESSION['id'];

        
        $totalBill = 0;
        $sql = "SELECT price, quantity FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.user_id = $userId";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $totalBill += ($row['price'] * $row['quantity']);
            }
        }

        
        $insertOrderQuery = "INSERT INTO orders (user_id, total_amount, name, contact_details, address, status) 
                             VALUES ($userId, $totalBill, '$name', '$contactNumber', '$address', 'pending')";

        $insertOrderResult = mysqli_query($conn, $insertOrderQuery);

        if ($insertOrderResult) {
        
            $clearCartQuery = "DELETE FROM cart WHERE user_id = $userId";
            $clearCartResult = mysqli_query($conn, $clearCartQuery);

            if ($clearCartResult) {
                echo 'Order confirmed and cart cleared!';
                header ("location:my-cart.php");
            } else {
                echo 'Order confirmed, but failed to clear cart: ' . mysqli_error($conn);
            }
        } else {
            echo 'Error confirming order: ' . mysqli_error($conn);
        }
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
       .aa {
            position: absolute;
            top:50%;
            left:50%;
            transform: translate(-50%,-50%);
            background-color: orange;
            padding:100px;
            border-radius: 40px;
          
          }
          form{
            padding:25px;
            display: grid;
            place-items: center;
            font-size: 20px;
            
          }
    </style>
</head>
<body>
    <div class="aa">
    <h1>Order Confirmation</h1>

    <?php
    if (!empty($errors)) {
        echo '<div style="color: red;">';
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        echo '</div>';
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $name; ?>" required><br>

        <label for="contact_number">Contact Number:</label>
        <input type="text" name="contact_number" value="<?php echo $contactNumber; ?>" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $address; ?>" required><br>

        <button type="submit" name="confirm_order" value="Confirm Order">confirm order</button>
    </form>
    </div>
</body>
</html>
