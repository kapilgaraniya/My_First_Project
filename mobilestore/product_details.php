<?php
session_start();
include("connection.php");
include("header.php");


if (isset($_GET['offer_id'])) {
    $offerId = $_GET['offer_id'];


    $offerQuery = "SELECT offers.id, products.name AS product_name, products.image AS product_image, products.detail1, products.detail2, products.price, products.id AS product_id
                   FROM offers
                   INNER JOIN products ON offers.product_id = products.id
                   WHERE offers.id = $offerId";
    $offerResult = mysqli_query($conn, $offerQuery);

    if ($offerResult && mysqli_num_rows($offerResult) > 0) {
        $offer = mysqli_fetch_assoc($offerResult);

        
        if (isset($_POST['add_to_cart'])) {
            
            if (isset($_SESSION['id'])) {
                $userId = $_SESSION['id'];
                $productId = $offer['product_id'];

                
                $cartCheckQuery = "SELECT * FROM cart WHERE user_id = $userId AND product_id = $productId";
                $cartCheckResult = mysqli_query($conn, $cartCheckQuery);

                if ($cartCheckResult && mysqli_num_rows($cartCheckResult) > 0) {
                    echo '<script>alert("Product is already in your cart!");</script>';
                } else {
                
                    $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $productId, 1)";
                    $insertResult = mysqli_query($conn, $insertQuery);

                    if ($insertResult) {
                        echo '<script>alert("Product added to cart!");</script>';
                    } else {
                        echo 'Failed to add product to cart: ' . mysqli_error($conn);
                    }
                }
            } else {
                echo 'User not logged in';
            }
        }
    } else {
        echo "Offer not found.";
        exit;
    }
} else {
    echo "Offer ID is not set. Please select an offer.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .offer-details-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        
        .offer-details img {
            max-width: 60%;
            height: 80%;
            margin: 20px 0;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

    
        .offer-details h2 {
            font-size: 20px;
            margin: 10px 0;
            color: #333;
        }

        
        .offer-details p {
            font-size: 16px;
            margin: 10px 0;
            color: #555;
        }

        
        .offer-details p.price {
            font-size: 18px;
            margin: 10px 0;
            color: #e44d26;
        }

        
        .offer-details button.add-to-cart {
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

        .offer-details button.add-to-cart:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="offer-details-container">
        <h1>Offer Details</h1>
        <?php
        if (isset($offer)) {
            echo '<div class="offer-details">';
            echo '<img src="admin/img/' . $offer['product_image'] . '" alt="' . $offer['product_name'] . '">';
            echo '<h2>' . $offer['product_name'] . '</h2>';
            echo '<p>' . $offer['detail1'] . '</p>';
            echo '<p>' . $offer['detail2'] . '</p>';
            echo '<p class="price">Price: $' . $offer['price'] . '</p>';
            
        
            if (isset($_SESSION['id'])) {
                echo '<form method="post">';
                echo '<button class="add-to-cart" name="add_to_cart">Add to Cart</button>';
                echo '</form>';
            } else {
                echo '<p>Please <a href="login.php" class="login-link">login</a> to add this product to your cart.</p>';
            }
            
            echo '</div>';
        } else {
            echo "Offer not found.";
        }
        ?>
    </div>
</body>
</html>
