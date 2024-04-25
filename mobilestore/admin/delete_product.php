<?php
include("config.php");

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

    $deleteProductQuery = "DELETE FROM products WHERE id = $productId";
    if (mysqli_query($conn, $deleteProductQuery)) {
        
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

        header("Location: all_pdt.php");
        exit();
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
