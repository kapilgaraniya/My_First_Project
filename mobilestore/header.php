<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iphone store</title>
    <style>
  *{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	text-decoration: none;
	} 
  .main{
	display: flex;
	justify-content: space-between;
	background-color: #1c1c24;
   }
   header{
	 height: 75px;
	 width: 800px;
	 display: flex;
	 flex-direction: row;
	 align-items: center;
	 justify-content: space-around;
     background-color: #1c1c24;
	}
nav a{
	color: white;
	text-decoration:none;
	padding: 4px 5px;
	margin: 5px;
	justify-content: space-around;
  }
  nav a:hover{
	background-color: white;
	color: red;
	border-radius: 8px;
  }
  .signup button{
	background-color: aqua;
	font-weight: 550;
	padding:4px 12px;
	border:2px solid grey;
	border-radius: 5px;
	outline: none;
	margin-left: 10px;
  }
  .signup button:last-child{
	background-color: #fa9579;
  }
  span{
	color:white;
  }
  </style>
</head>
<body>
    <div class="main">
        <img src="images/logo.jpg" width="250px" height="80px">
        <header>
            <nav>
                <a href="INDEX.PHP">HOME</a>
                <a href="offer.PHP">OFFERS</a>
                <a href="CATEGORIES.PHP">CATEGORIES</a>
                <a href="ABOUTUS.PHP">ABOUT US</a>
                <a href="feedback.PHP">FEEDBACK</a>
                <a href="MY-CART.PHP">MY CART</a>
                <?php
                session_start();
                if (isset($_SESSION['ulogged_in'])) {
                    echo '<a href="logout.php">LOGOUT</a>';
                    echo '<span>Welcome, ' . $_SESSION['username'] . '</span>';
                } else {
                    echo '<a href="login.php">LOGIN</a>';
                    echo '<a href="signup.php">SIGN-UP</a>';
                }
                ?>
            </nav>
        </header>
    </div>
