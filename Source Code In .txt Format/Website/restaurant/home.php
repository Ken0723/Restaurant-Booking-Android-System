<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Home</title>
    <link rel="stylesheet" href="../css/style.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <head>

    </head>
    <body>
        <?php
        require_once('../checkLogin.php');
        ?>
        <ul>

            <li><a href="./home.php">Home</a></li>

            <li><a href="./makeOrders.php">Make the orders</a></li>

            <li><a href="./viewOrders.php">View orders records</a></li>

            <li style="float:right"><a href="../logout.php">Logout</a></li>

            <li style="float:right"><a href="./viewDealer.php">Dealer's profile</a></li> 

        </ul>

        <div id="main">
            <center>
                <font size="7" color="#33ccff">
                <h1>Welcome!</h1>
                <p>Order Processing and Stock Recording System - Dealer</p>
                </font>
            </center>
        </div> 
    </body>
</html>
