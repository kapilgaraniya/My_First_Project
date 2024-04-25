<?php
include("index.php");
include("config.php");


$productID = '';
$productIDErr = '';
$offerImage = '';
$uploadPath = 'img/'; 


$productsQuery = "SELECT id, name FROM products";
$productsResult = mysqli_query($conn, $productsQuery);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["product_id"])) {
        $productIDErr = "Product ID is required";
    } else {
        $productID = $_POST["product_id"];
    }

    
    if (!empty($_FILES["offer_image"]["name"])) {
        $offerImage = $_FILES["offer_image"]["name"];
        $targetFilePath = $uploadPath . basename($offerImage);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        
        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileType, $allowTypes)) {
            
            if (move_uploaded_file($_FILES["offer_image"]["tmp_name"], $targetFilePath)) {
                
                $insertOfferQuery = "INSERT INTO offers (product_id, offer_image) VALUES ('$productID', '$offerImage')";
                if (mysqli_query($conn, $insertOfferQuery)) {
                    echo '<div class="success-msg">Offer added successfully.</div>';
                } else {
                    echo '<div class="error-msg">Error adding offer: ' . mysqli_error($conn) . '</div>';
                }
            } else {
                echo '<div class="error-msg">Error uploading offer image.</div>';
            }
        } else {
            echo '<div class="error-msg">Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.</div>';
        }
    } else {
        echo '<div class="error-msg">Offer image is required.</div>';
    }
}


$offersQuery = "SELECT offers.id, products.name AS product_name, offers.offer_image 
                FROM offers 
                INNER JOIN products ON offers.product_id = products.id";
$offersResult = mysqli_query($conn, $offersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Offer</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: grey;
        }

        .admin-container {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: brown;
            border-radius: 50px;
            padding: 60px;
        }

        .eee {
            display: grid;
            place-items: center;
            font-size: 25px;
            padding: 20px;
        }

        h1 {
            color: blue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="eee">
            <h1>Add Offer</h1>
            <form method="post" enctype="multipart/form-data">
                <label for="product_id">Product:</label>
                <select name="product_id">
                    <?php
                    if ($productsResult && mysqli_num_rows($productsResult) > 0) {
                        while ($product = mysqli_fetch_assoc($productsResult)) {

                            $tQuery = "SELECT id FROM offers WHERE product_id = ".$product['id'];

                            echo $tQuery;
                            $tResult = mysqli_query($conn, $tQuery);

                            

                            if( mysqli_num_rows($tResult) > 0){
                                

                            }else{

                            echo '<option value="' . $product['id'] . '">' . $product['name'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <span class="error"><?php echo $productIDErr; ?></span><br>

                <label for="offer_image">Offer Image:</label>
                <input type="file" name="offer_image" accept="image/*" required>

                <input type="submit" value="Add Offer">
            </form>
        </div>
        <h1>Offer List</h1>
        <table>
            <tr>
                <th>Offer ID</th>
                <th>Product Name</th>
                <th>Offer Image</th>
                <th>Action</th>
            </tr>
            <?php
            while ($offer = mysqli_fetch_assoc($offersResult)) {
                echo '<tr>';
                echo '<td>' . $offer['id'] . '</td>';
                echo '<td>' . $offer['product_name'] . '</td>';
                echo '<td><img src="img/' . $offer['offer_image'] . '" height="100"></td>';
                echo '<td><a href="delete_offer.php?offer_id=' . $offer['id'] . '">Delete</a></td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</body>
</html>
