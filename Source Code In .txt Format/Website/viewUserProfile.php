<?php
    require_once('./checkLogin.php');
    ?>
<!DOCTYPE html>
<html>





<head>
    <title>User Profile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/myStyle.css" />
    <link rel="stylesheet" href="./css/layout.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .min-menu ul {
            list-style: none;
            margin: 0px;
            padding: 0px;

            background-color: grey;
            text-shadow: 2px 2px 2px red;
            border-radius: 10px;
            display: inline-block;
        }

        .min-menu a {
            text-decoration: none;
            padding: 10px 20px;
            line-height: 1.2em;
            color: white;
            display: block;
        }

        .min-menu a:hover {
            background-color: lightgreen;
            color: black;
        }

        .min-menu .sub {
            position: absolute;
            top: auto;
            background-color: darkblue;
            box-shadow: 10px 10px 5px grey;
            transform: rotate(0deg);
        }

        .min-menu .sub a:hover {
            background-color: lightblue;
        }

        .min-menu .sub li {
            overflow: hidden;
            height: 0px;
            transition: height 500ms;
        }

        .min-menu ul li:hover .sub li {
            height: 40px;
        }

        input[type=text] {
            width: 600px;
        }

        input[type=submit] {
            width: 600px;
        }
    </style>

    
</head>

<body>

        <?php
            include_once('./template/header.php');
        ?>

        <br />

        <div id="main">
            <div class="row">
                <div class="col-75">
                    <div class="container">
                        <form method="post" action="./saveUserInfo.php">

                            <div class="row">
                                <div class="col-50">

                                    <div class="min-menu" align="center">
                                        <ul>
                                            <li>
                                                <a href="./viewUserProfile.php">Profile</a>
                                            </li>
                                        </ul>

                                        <ul>
                                            <li>
                                                <a href="./changePassword.php">Change password</a>
                                            </li>
                                        </ul>



                                    </div>


                                    <?php
                                    require_once('./conn.php');
                                    $userEmail = $_SESSION['login_user'];
                                    $sql = "SELECT * FROM user where Email = '$userEmail'";
                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                    $rc = mysqli_fetch_assoc($result);
                                    $UserID = $rc['ID'];
                                    $Email = $rc['Email'];
                                    
                                    $GroupID = $rc['GroupID'];

                                    $LastName = '1';
                                    $FirstName = '';
                                    if ($GroupID > 0) {
                                        $sql = "SELECT * FROM employee where UserID = '$UserID'";
                                        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                        $rc = mysqli_fetch_assoc($result);
                                        $LastName = $rc['LastName'];
                                        $FirstName = $rc['FirstName'];
                                        $JobTitle = $rc['JobTitle'];
                                        $Phone = $rc['Phone'];
                                        $Address = $rc['Address'];
                                    } else {
                                        $sql = "SELECT * FROM customer where UserID = '$UserID'";
                                        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                        $rc = mysqli_fetch_assoc($result);
                                        $LastName = $rc['LastName'];
                                        $FirstName = $rc['FirstName'];
                                        $Phone = $rc['Phone'];
                                        $Address = $rc['Address'];
                                    }

                                    $form = <<<EOD
                                <h1>User Profile</h1>
                                <label for="tfEmail"><i class="fa fa-user"></i> Email </label>
                                <input type="text" id="tfEmail" name="tfEmail" value="%s" readonly="readonly"  />

                                <label for="tfLastName"><i class="fa fa-user-o"></i> Last Name </label>
                                <input type="text" id="tfLastName" name="tfLastName" value="%s" />

                                <label for="tfFirstName"><i class="fa fa-user-o"></i> First Name </label>
                                <input type="text" id="tfFirstName" name="tfFirstName" value="%s" />

                                <label for="tfPhoneNumber"><i class="fa fa-phone"></i> Phone Number </label>
                                <input type="text" id="tfPhoneNumber" name="tfPhoneNumber" value="%s">        
                                        
                                <label for="tfAddress"><i class="fa fa-address-card-o"></i> Address </label>
                                <input type="text" id="tfAddress" name="tfAddress" value="%s">                                

EOD;


                                    printf($form, $Email, $LastName, $FirstName, $Phone, $Address);

                                    mysqli_free_result($result);
                                    ?>

                                </div>

                            </div>

                            <input type="submit" value="Save" class="btn">
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <?php
            include_once('./template/footer.php');
        ?>
    </div>
</body>

</html>