<?php include("config.php"); ?>
<?php include("index.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="all_pdt.css">
    <style>
        body{
            background-color: grey;
        }
        .all{
            
            border-radius: 50px;
            
        }
        
 .all{
    
    height: 500px;
    width: 1000px;
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.admin-container{

    height: 500px;
    width: 1000px;
    font-size: larger;    
    display: grid;
    place-items:center;
}
.admin-container h1{
    margin-top: 70px;
}
table {
    background-color: brown; 
}
td {
    padding: 5px;
}
h1{
    color: blue;
}

    </style>
</head>
<body>
<div class="all">
    

    <div class="admin-container">
        <h1>Manage Products</h1><br>
        <br>
        <table border=1>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>In Stock</th>
                <th>Image</th> 
                <th>Actions</th>
            </tr>
            <?php
            $productsQuery = "SELECT products.*, categories.name AS category_name FROM products
                              INNER JOIN categories ON products.category_id = categories.id";
            $productsResult = mysqli_query($conn, $productsQuery);

            if ($productsResult && mysqli_num_rows($productsResult) > 0) {
                while ($product = mysqli_fetch_assoc($productsResult)) {
                    echo '<tr>';
                    echo '<td>' . $product['id'] . '</td>';
                    echo '<td>' . $product['name'] . '</td>';
                    echo '<td>$' . $product['price'] . '</td>';
                    echo '<td>' . $product['category_name'] . '</td>';
                    echo '<td>' . ($product['instock'] ? 'Yes' : 'No') . '</td>';
                    echo '<td><img src="img/' . $product['image'] . '" alt="' . $product['name'] . '" width="100"></td>';
                    echo '<td>';
                    echo '<a href="edit_pdt.php?id=' . $product['id'] . '">Edit</a> | ';
                    echo '<a href="delete_product.php?id=' . $product['id'] . '">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7">No products found.</td></tr>';
            }
            ?>
        </table>
    </div>
    </div>
</body>
</html>
