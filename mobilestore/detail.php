<?php
include('connection.php');
include('header.php');

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        $productQuery = "SELECT * FROM products WHERE id = $productId";
        $productResult = mysqli_query($conn, $productQuery);

        if ($productResult && mysqli_num_rows($productResult) > 0) {
            $product = mysqli_fetch_assoc($productResult);

            if (isset($_POST['add_to_cart'])) {
                $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $productId, 1)";
                $insertResult = mysqli_query($conn, $insertQuery);

                if ($insertResult) {
                    echo '<script>alert("Product added to cart!");</script>';
                } else {
                    echo 'Failed to add product to cart: ' . mysqli_error($conn);
                }
            }
        } else {
            echo 'Product not found.';
        }
    } else {
        echo 'Product ID not provided.';
    }
} else {
    echo 'User not logged in';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>


        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Product-specific styles */
        .item-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        .item-container img {
            max-width: 20%;
            height: auto;
            margin-bottom: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .item-container h2 {
            font-size: 24px;
            margin: 10px 0;
            color: #333;
        }

        .item-container p {
            font-size: 16px;
            margin: 10px 0;
            color: #555;
        }

        .item-container p.price {
            font-size: 18px;
            margin: 10px 0;
            color: #e44d26;
        }

        .item-container button.add-to-cart {
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .item-container button.add-to-cart:hover {
            background-color: #0056b3;
        }

        .login-link {
            color: #333;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="content">
        <div class="item-container">
            <?php
            if (isset($_GET['id'])) {
                $productId = $_GET['id'];

                $sql = "SELECT * FROM products WHERE id = $productId";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $product = mysqli_fetch_assoc($result);
            ?>
            <img src="admin/img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <h2><?php echo $product['name']; ?></h2>
            <p><?php echo $product['detail1']; ?></p>
            <p><?php echo $product['detail2']; ?></p>
            <p class="price">Price: $<?php echo $product['price']; ?></p>
            
            <?php if (isset($_SESSION['id'])) { ?>
            <form method="post">
                <button class="add-to-cart" name="add_to_cart">Add to Cart</button>
            </form>
            <?php } else { ?>
            <p>Please <a href="login.php" class="login-link">login</a> to add this product to your cart.</p>
            <?php } ?>
            <?php
                } else {
                    echo 'Product not found.';
                }
            } else {
                echo 'Product ID not provided.';
            }
            ?>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>
