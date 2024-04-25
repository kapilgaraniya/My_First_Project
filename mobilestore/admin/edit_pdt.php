<?php
include("config.php");

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $detail1 = $_POST["detail1"];
        $detail2 = $_POST["detail2"];
        $price = $_POST["price"];
        $category = $_POST["category"];
        $instock = isset($_POST["instock"]) ? 1 : 0;

        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            $uploadedFileName = $_FILES['image']['name'];
            $uploadedFileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);

            
            $newFileName = uniqid('product_') . '.' . $uploadedFileExtension;

            
            $uploadDirectory = 'img/';

        
            $uploadedFilePath = $uploadDirectory . $newFileName;

            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFilePath)) {
                
                $updateQuery = "UPDATE products SET
                                name = '$name',
                                detail1 = '$detail1',
                                detail2 = '$detail2',
                                price = '$price',
                                category_id = '$category',
                                instock = '$instock',
                                image = '$newFileName'
                                WHERE id = $productId";

                if (mysqli_query($conn, $updateQuery)) {
                    header("Location: all_pdt.php");
                    exit();
                } else {
                    echo "Error updating product: " . mysqli_error($conn);
                }
            } else {
                echo "Error uploading image.";
            }
        } else {
            
            $updateQuery = "UPDATE products SET
                            name = '$name',
                            detail1 = '$detail1',
                            detail2 = '$detail2',
                            price = '$price',
                            category_id = '$category',
                            instock = '$instock'
                            WHERE id = $productId";

            if (mysqli_query($conn, $updateQuery)) {
                header("Location: all_pdt.php");
                exit();
            } else {
                echo "Error updating product: " . mysqli_error($conn);
            }
        }
    }

    $productQuery = "SELECT * FROM products WHERE id = $productId";
    $productResult = mysqli_query($conn, $productQuery);
    $product = mysqli_fetch_assoc($productResult);

    $categoriesQuery = "SELECT * FROM categories";
    $categoriesResult = mysqli_query($conn, $categoriesQuery);
} else {
    header("Location: all_pdt.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container{
            position: absolute;
   top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    font-size: 20px;
    background-color: brown;
    border-radius: 50px;
    padding: 60px;
        }
        .h1{
            color: blue;
        }
    </style>
</head>
<body>
    <?php include("index.php"); ?>

    <div class="admin-container">
        <h1>Edit Product</h1><br>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br><br>

            <label for="detail1">Detail 1:</label>
            <input type="text" name="detail1" value="<?php echo $product['detail1']; ?>" required><br><br>

            <label for="detail2">Detail 2:</label>
            <input type="text" name="detail2" value="<?php echo $product['detail2']; ?>" required><br><br>

            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required><br><br>

            <label for="category">Category:</label>
            <select name="category">
                <?php
                while ($category = mysqli_fetch_assoc($categoriesResult)) {
                    $selected = ($category['id'] == $product['category_id']) ? 'selected' : '';
                    echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                }
                ?>
            </select><br><br>

            <label for="instock">In Stock:</label>
            <input type="checkbox" name="instock" value="1" <?php echo ($product['instock'] ? 'checked' : ''); ?>><br><br>

            <label for="image">Product Image:</label>
            <input type="file" name="image" accept="image/*"><br><br>

            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
</html>
