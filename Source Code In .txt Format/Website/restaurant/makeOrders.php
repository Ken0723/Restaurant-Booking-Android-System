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

        <script type="text/javascript">

            function getPart(partNumber, stockQuantity, stockPrice, partName) {
                //alert(document.getElementById('num' + partNumber).value);
                if (document.getElementById('num' + partNumber).value > stockQuantity) {
                    document.getElementById('num' + partNumber).value = stockQuantity;
                }

                var qty = document.getElementById('num' + partNumber).value;
                document.getElementById('quantity' + partNumber).value = qty;

            }

        </script>

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
                    <form method="post" action="./makeOrderCart.php">

                        <div class="row">
                            <div class="col-50">
                                <h1>Mark the Order</h1>
                                <label for="fname"><i class="fa fa-address-card-o"></i> Delivery Address </label>
                                <input type="text" id="tfDeliveryAddress" name="tfDeliveryAddress" value="" placeholder="If necessary" />
                            </div>

                            <div class="col-50">
                                <h3>Product</h3>

                                <div id="item" class="overflow" align="center">
                                    <div id="textDiv" style="border: 5px inset #98bf21; padding:3px">
                                        <?php
                                        require_once('../conn.php');

                                        $sql = "SELECT * FROM part WHERE stockStatus='Available';";
                                        $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                                        $numOfPart = 1;
                                        while ($rc = mysqli_fetch_assoc($rs)) {

                                            printf('<fieldset>
		
                                                        <label class="part" for="%1$d">
                                                             Unit Price:$ %4$d &nbsp&nbsp&nbsp Name: %2$s
                                                        </label>
                                                        <input type="number" id="num%1$d" name="%1$d" value="0" min="0" max="%3$d" onkeyup="getPart(%1$d, %3$d, %4$d, \'%2$s\');" oninput="getPart(%1$d, %3$d, %4$d, \'%2$s\');" />
                                                        
                                                   </fieldset>
                                                   <input type="hidden" name="quantity%1$d" id="quantity%1$d" value="0" />'
                                                    , $rc['partNumber'], $rc['partName'], $rc['stockQuantity'], $rc['stockPrice']);
                                        }


                                        mysqli_free_result($rs);
                                        ?>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <input type="submit" value="Continue to checkout" class="btn">
                    </form>
                </div>
            </div>

        </div>

    </body>
</html>
