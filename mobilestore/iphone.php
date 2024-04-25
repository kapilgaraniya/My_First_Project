<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="iphone.css"> 
</head>
<body>
    <?php include("header.php"); ?>
    
    <div class="content">
        <?php
        include('connection.php');
        
        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];
            $categoryQuery = "SELECT name FROM categories WHERE id = $categoryId";
            $categoryResult = mysqli_query($conn, $categoryQuery);
            $category = mysqli_fetch_assoc($categoryResult);
        
            echo '<h2>' . $category['name'] . '</h2>';
        
            $sql = "SELECT * FROM products WHERE category_id = $categoryId";
            $result = mysqli_query($conn, $sql);
        
            if ($result && mysqli_num_rows($result) > 0) {
                echo '<div class="item-container">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="item">';
                    echo '<div class="item-img-1">';
                    echo '<a class="img" href="detail.php?id=' . $row['id'] . '"><img src="admin/img/' . $row['image'] . '" height="100px"></a>';
                    echo '<h4>' . $row['name'] . '</h4>';
                    echo '<pre>' . $row['detail1'] . '</pre>';
                    echo '<pre>$ ' . $row['price'] . '</pre>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo 'No products found for this category.';
            }
        
            mysqli_close($conn);
        } else {
            echo 'Category ID not provided.';
        }
        ?>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
