<?php
include("config.php");

if (isset($_GET['offer_id'])) {
    $offerId = $_GET['offer_id'];

    
    $deleteOfferQuery = "DELETE FROM offers WHERE id = $offerId";
    if (mysqli_query($conn, $deleteOfferQuery)) {
    
        header("Location: offer.php"); 
        exit();
    } else {
        echo 'Error deleting offer: ' . mysqli_error($conn);
    }
} else {
    
    header("Location: offer.php");
    exit();
}
?>
