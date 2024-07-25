<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>View dealer</title>
    <link rel="stylesheet" href="../css/style.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <head>

        <style>

            .menu ul{
                list-style:none;
                margin:0px;
                padding:0px;

                background-color:grey;
                text-shadow:2px 2px 2px red;
                border-radius:10px;
                display:inline-block;
            }

            .menu a{
                text-decoration:none;
                padding:10px 20px;
                line-height:1.2em;
                color:white;	
                display:block;
            }

            .menu a:hover {
                background-color:lightgreen;
                color:black;
            }

            .menu .sub{
                position:absolute;
                top:auto;
                background-color:darkblue;
                box-shadow:10px 10px 5px grey;
                transform:rotate(0deg);
            }

            .menu .sub a:hover{
                background-color:lightblue;
            }

            .menu .sub li{
                overflow:hidden;
                height:0px;
                transition:height 500ms;
            }

            .menu ul li:hover .sub li{
                height: 40px;
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

        <br />
        <div class="row">
            <div class="col-75">
                <div class="container">
                    <form method="post" action="saveDealerInfo.php">

                        <div class="row">
                            <div class="col-50">

                                <div class="menu" align="center">
                                    <ul>
                                        <li>
                                            <a href="./viewDealer.php">Profile</a>			
                                        </li>
                                    </ul>

                                    <ul>
                                        <li>
                                            <a href="./changePassword.php">Change password</a>
                                        </li>
                                    </ul>



                                </div>


                                <?php
                                require_once('../conn.php');
                                $dealerID = $_SESSION['login_user'];
                                $sql = "SELECT * FROM dealer where dealerID = '$dealerID'";
                                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                $rc = mysqli_fetch_assoc($result);

                                $form = <<<EOD
                                <h1>Dealer's profile</h1>
                                <label for="tfDealerID"><i class="fa fa-user"></i> DealerID </label>
                                <input type="text" id="tfDealerID" name="tfDealerID" value="%s" readonly="readonly"  />

                                <label for="tfName"><i class="fa fa-user-o"></i> Name </label>
                                <input type="text" id="tfName" name="tfName" value="%s" />

                                <label for="tfPhoneNumber"><i class="fa fa-phone"></i> Phone Number </label>
                                <input type="text" id="tfPhoneNumber" name="tfPhoneNumber" value="%s">        
                                        
                                <label for="tfAddress"><i class="fa fa-address-card-o"></i> Address </label>
                                <input type="text" id="tfAddress" name="tfAddress" value="%s">

EOD;


                                printf($form, $rc['dealerID'], $rc['name'], $rc['phoneNumber'], $rc['address']);

                                mysqli_free_result($result);
                                ?>

                            </div>

                        </div>

                        <input type="submit" value="Save" class="btn">
                    </form>
                </div>
            </div>

        </div>

    </body>
</html>
