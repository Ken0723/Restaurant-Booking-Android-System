<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Make the order</title>
    <link rel="stylesheet" href="../css/style.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <head>
        <?php
        require_once('../checkLogin.php');
        
        ?>

        <style>
            .btn {
                margin-top: 35px;
                font-size: 22px;
            }

            .btn2 {
                background-color: #115bd8;
                color: white;
                padding: 12px;
                margin: 10px 0;
                border: none;
                width: 300px;
                border-radius: 3px;
                cursor: pointer;
                font-size: 17px;
            }

            input[type=number] {
                margin-top: 10px;
                margin-bottom: 12px;
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 3px;
                width: 100px;
            }

            fieldset{
                background-color: #e0e0e0;
                border: none;
                border-radius: 20px;
                margin-bottom: 12px;
                overflow: hidden;
                padding: 0 .625em;
            }

            label.part{
                cursor: pointer;
                display: inline-block;
                padding: 3px 6px;
                text-align: right;
                margin-top: 12px;
                vertical-align: top;
                background-color: pink;
                font-weight: bold;
            }

            input{
                font-size: inherit;
            }

            div.overflow{
                overflow-y:scroll;
                height: 550px;
            }
        </style>

    </head>
    <body>

        <ul>

            <li><a href="./home.php">Home</a></li>

            <li><a href="./makeOrders.php">Make the orders</a></li>

            <li><a href="./viewOrders.php">View orders records</a></li>

            <li style="float:right"><a href="../logout.php">Logout</a></li>

            <li style="float:right"><a href="./viewDealer.php">Dealer's profile</a></li> 

        </ul>

        <br />

        <div class="row">
            <div class="col-75">
                <div class="container">
                    
                    <div id="myCart">
                        <form method="post" action="./generate_order.php">
                        <?php
                        require_once('../conn.php');


                        $sql = "SELECT * FROM part WHERE stockStatus='Available';";
                        $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        $numOfPart = 0; 
                        $totalPrice = 0;
                        $i = 0;
                        $arr=array();
                        $test="";
						
						
                        while ($rc = mysqli_fetch_assoc($rs)) {
							
						
                            $test = "quantity".$rc['partNumber']."";
							    
                            if ($_POST[$test] > 0) {
                               
                                $Quantity = $_POST['quantity' + $rc['partNumber']];
                                $Price = (float) $Quantity * $rc['stockPrice'];
                                $totalPrice += $Price;
                                $arr[$i++] = "<p>$rc[partName] <span class=\"price\">$Quantity</span></p>";
                              //  echo "<script>console.log($rc[partName] + $Quantity);</script>";
                                printf('<input type="hidden" name="quantity%1$d" id="quantity%1$d" value="%2$d" />'
                                            , $rc['partNumber'], $Quantity);
                                $numOfPart++;
                            }
                        }
                        printf('<input type="hidden" name="tfDeliveryAddress" id="tfDeliveryAddress" value="%s" />'
                                            , $_POST["tfDeliveryAddress"]);
                        printf('<h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b>%d</b></span></h4>', $numOfPart);

                        for ($i = 0; $i < count($arr); $i++) {
                            echo $arr[$i];
                        }
                        printf('<hr />
                        <p>Total <span class="price" style="color:black"><b>$ %.2f </b></span></p>', $totalPrice);

                        mysqli_free_result($rs);
                        ?>

                        <input type="submit" value="Continue to checkout" class="btn">
                        </form>
                    </div>
                </div>
            </div>
        </div>>
    </body>
</html>
