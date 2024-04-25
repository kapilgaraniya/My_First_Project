<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="categories.css">
</head>
<body>
    
<?php include("header.php"); ?>

<div class="massage">
 <form>
  <b>Please Select Your Category</b><br>
  <div class="btn">
    <?php
    include('connection.php');

    $categoriesQuery = "SELECT * FROM categories";
    $categoriesResult = mysqli_query($conn, $categoriesQuery);

    if ($categoriesResult && mysqli_num_rows($categoriesResult) > 0) {
        while ($category = mysqli_fetch_assoc($categoriesResult)) {
            echo '<button><a href="iphone.php?id=' . $category['id'] . '">' . $category['name'] . '</a></button>';
        }
    } else {
        echo 'No categories found.';
    }

    mysqli_close($conn);
    ?>
  </div>
 </form>
</div>

<?php include ('footer.php'); ?>
</body>
</html>
