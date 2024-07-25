<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>View order details</title>
    <link rel="stylesheet" href="../css/style.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <head>
        <script>
            function search(orderID) {
                if (document.getElementById("codi").value != "") {
                    location.replace("viewOrdersDetail.php?orderID=" + orderID + "&partNumber=" + document.getElementById("codi").value);
                } else {
                    location.replace("viewOrdersDetail.php?orderID=" + orderID);
                }
            }
        </script>

        <style>
            .divTable{
                display: table;
                width: 100%;
            }
            .divTableRow {
                display: table-row;
            }
            .divTableHeading {
                background-color: #EEE;
                display: table-header-group;
            }
            .divTableCell, .divTableHead {
                border: 1px solid #999999;
                display: table-cell;
                padding: 3px 10px;
            }
            .divTableHeading {
                background-color: #EEE;
                display: table-header-group;
                font-weight: bold;
            }
            .divTableFoot {
                background-color: #EEE;
                display: table-footer-group;
                font-weight: bold;
            }
            .divTableBody {
                display: table-row-group;
            }
            #Cancel{
                position: relative;
                left:32%;
            }
            #backButton{
                position: relative;
                top:30px;
            }

            input[type=text] {
                width: 100px;
            }

            #codi{
                width: 300px;
            }
        </style>
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
                <H1>Order Details of OrderID:(<u><?php echo $_GET['orderID']; ?></u>)</H1>
                <input type="text" id="codi" placeholder="Enter Part Number or Part Name for search" size="75%" />
                <input type="button" id="searchtext" value="search" onClick="search(<?php echo "$_GET[orderID]"; ?>);">
                <br></br>

                <div class="divTable" style="width: 85%; border: 1px solid #000;">
                    <div class="divTableBody">
                        <div class="divTableRow">
                            <div class="divTableCell"><b>Part Number</b></div>
                            <div class="divTableCell"><b>Part name</b></div>
                            <div class="divTableCell"><b>Quantity</b></div>

                            <div class="divTableCell"><b>Total Price of parts</b></div>

                        </div>

                        <?php

                        if (isset($_GET["partNumber"])) {
                            $codition = "orderpart.partNumber=$_GET[partNumber] AND";
                        } else {
                            $codition = "";
                        }
                        require_once('../conn.php');
                        $sql = "select orderID, orderpart.partNumber, quantity, price, part.partNumber, partName from orderpart, part WHERE $codition (orderID=$_GET[orderID] AND orderpart.partNumber=part.partNumber) order by orderpart.partNumber ASC;";
                        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));


                        $totalPrice = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            printf('<div class="divTableRow">
                            <div class="divTableCell">%s</div>
                            <div class="divTableCell">%s</div>
                            <div class="divTableCell">%s</div>
                            <div class="divTableCell">%s</div>
                            </div>'
                                    , $row["partNumber"], $row["partName"], $row["quantity"], $row["price"]);
                            $totalPrice += $row["price"];
                        }

                        printf('
                                    </div>
                                </div>
                               <div id="Cancel">
                                    Total Price$ <input type="text" value="%.2f" readonly="readonly" /></div>
                            </center>', $totalPrice);
                        mysqli_free_result($result);
                        mysqli_close($conn);
                        ?>
                        <center>
                            <input type="button" class="btn" id="backButton" value="Go back" style="WIDTH: 85%" onclick="window.location.href='viewOrders.php';">
                        </center>
                    </div>

                    </body>
                    </html>
