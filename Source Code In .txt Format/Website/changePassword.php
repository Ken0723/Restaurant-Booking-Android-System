<?php
    require_once('./checkLogin.php');
    ?>
<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>

    <title>Change password</title>

    <link rel="stylesheet" href="./css/myStyle.css" />
    <link rel="stylesheet" href="./css/layout.css" />
    <link rel="stylesheet" href="./css/viewRestaurant.css" />
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

        input[type=password] {
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

                                <center>
                                    <h1>Change password</h1>
                                </center>
                                <form method="post" action="./saveUserPassword.php">



                                    <label for="tfOldPassword"><i class="fa fa-lock"></i> Old password</label>
                                    <input type="password" id="tfOldPassword" name="tfOldPassword" value="" required />

                                    <label for="tfNewPassword"><i class="fa fa-lock"></i> New password</label>
                                    <input type="password" id="tfNewPassword" name="tfNewPassword" value="" required />

                                    <label for="tfRePassword"><i class="fa fa-lock"></i> Confirm new password</label>
                                    <input type="password" id="tfRePassword" name="tfRePassword" value="" required />



                            </div>

                        </div>

                        <center><input type="submit" value="Update password" class="btn"></center>

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