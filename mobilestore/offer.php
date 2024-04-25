<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .marquee-container {
            width: 100%;
            overflow: hidden;
            
            
        }

        .marquee {
            white-space: nowrap;
            animation: marquee 20s linear infinite;
        }

        .marquee a {
            display: inline-block;
            margin-right: 20px; 
        }

        .marquee img {
            margin-top: 20px;
            width: 1200px; 
            height: 600px;
            object-fit: cover;
        }

        
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>

    <div class="marquee-container">
        <div class="marquee">
            <?php
            include("connection.php");

            $adminOffersQuery = "SELECT offers.id, offers.offer_image, products.name FROM offers
                                INNER JOIN products ON offers.product_id = products.id
                                WHERE offers.offer_image IS NOT NULL";
            $adminOffersResult = mysqli_query($conn, $adminOffersQuery);

            if ($adminOffersResult && mysqli_num_rows($adminOffersResult) > 0) {
                while ($offer = mysqli_fetch_assoc($adminOffersResult)) {
                    echo '<a href="product_details.php?offer_id=' . $offer['id'] . '">';
                    echo '<img src="admin/img/' . $offer['offer_image'] . '" alt="' . $offer['name'] . '">';
                    echo '</a>';
                }
            } else {
                echo '<p>No admin offers available.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
