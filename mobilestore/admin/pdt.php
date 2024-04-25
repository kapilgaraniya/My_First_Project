<?php

include("config.php");

$name = $detail1 = $price = $category = $instock = $image = "";
$uploadPath = "img/";

$categoriesQuery = "SELECT * FROM categories";
$categoriesResult = mysqli_query($conn, $categoriesQuery);
$categories = mysqli_fetch_all($categoriesResult, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $detail1 = $_POST["detail1"];
    $detail2 = $_POST["detail2"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $instock = isset($_POST["instock"]) ? 1 : 0;

    $imageFileName = $_FILES["image"]["name"];
    $imageTmpName = $_FILES["image"]["tmp_name"];
    $imagePath = $uploadPath . $imageFileName;

    if (move_uploaded_file($imageTmpName, $imagePath)) {
        $sql = "INSERT INTO products (name, detail1,detail2, price, image, category_id, instock)
                VALUES ('$name', '$detail1','$detail2', '$price', '$imageFileName', '$category', '$instock')";

        if (mysqli_query($conn, $sql)) {
            
            header("Location: pdt.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Image upload failed.";
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
    <title>Add Product</title>
    <link rel="stylesheet" href=".css">
    <style>
body{
            background-color: grey;
        }
        form{
            background-color: brown;
            border-radius: 50px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            padding: 4%;
        }
   

h1{
    color: blue;
    letter-spacing: 1px;
}
div{
    padding: 10px;
}
.btn input{
    color: blue;
    background-color: black;
    padding: 10px 20px 10px 20px ;
    border-radius: 8px;
} */

    </style>

</head>
<body>
    <?php include("index.php"); ?>

    <div class="admin-container">
        
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <h1>Add New Product</h1><br>
        <div>
            <label for="name">Product Name:</label>
            <input type="text" name="name" required><br>
        </div>
<div>
            <label for="detail1">detail1:</label>
            <textarea name="detail1" rows="2" required></textarea><br>
        </div>
<div>
            <label for="detail2">detail2:</label>
            <textarea name="detail2" rows="5" required></textarea><br>
            </div>
<div>
            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" required><br>
</div>
<div>
            <label for="category">Category:</label>
<select name="category">
    <?php foreach ($categories as $category) : ?>
        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
    <?php endforeach; ?>
</select><br>
</div>
<div>
            <label for="instock">In Stock:</label>
            <input type="checkbox" name="instock" value="1"><br>
            </div>
<div>
            <label for="image">Image:</label>
            <input type="file" name="image" accept="image/*" required><br>
            </div>
<div>
            <input type="submit" name="add_product" value="Add Product">
            </div>
        </form>
    </div>

    
</body>
</html>
