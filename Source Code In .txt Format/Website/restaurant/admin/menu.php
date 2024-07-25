<?php
require_once '../../checkLogin.php';
?>
<html>

<head>
    <link rel="stylesheet" href="../../css/myStyle.css" />
    <link rel="stylesheet" href="../../css/layout.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <title>Menu</title>
    <?php
    extract($_GET);
    

    if ($_SESSION["role"] != "resadmin") {
        echo "<script type='text/javascript'>alert('you are not admin already!');window.location.href='../../index.php';</script>";
    }
    ?>

    <style type="text/css">
        input[type=button] {
            width: 100%;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
        }

        input[type=button]:hover {
            opacity: 0.5;
        }

        input[type=submit] {
            width: 100px;
        }

        #resetButton {
            background-color: #999;
            width: 100px;
            margin: 50px 150px;
        }

        .edit-btn {
            background-color: #C4E1E1;
        }

        .edit-btn:hover {
            background-color: #97CBFF;
        }

        .delete-btn {
            background-color: #FFB5B5;
        }

        .delete-btn:hover {
            background-color: #FF2D2D;
        }
    </style>



</head>

<body>
    <?php
            include_once('./header.php');
        ?>
        <br />
        <br />
        <div id="main">
            <center>
                <h1> Menu </h1>
            </center>

            <?php
            require_once('../../conn.php');

            $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_SESSION[Restaurant_id]' and FoodCategory='Breakfast' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            print('
            <div class="menu-container">
                    <h3 class="title-name"> Breakfast </h3>
                    <table>
                        <th> Code </th> <th> Name </th><th> Food Category </th><th> Price </th> <th> Edit </th> <th> Delete </th>');
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> %3$s </td>
                                    <td> $ %4$s </td> 
                                    <td><button class="edit-btn">
                                                    <a href="editMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">edit</i>
                                                    </a></button></td>
                                    <td><button class="delete-btn">
                                                    <a href="deleteMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">delete_forever</i>
                    								</a></button></td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['FoodCategory'], $rc['PriceEach']);
                        }
            print('
                    </table>
                </div> <hr />
            ');

            
            
            
            $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_SESSION[Restaurant_id]' and FoodCategory='Lunch' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            print('
            <div class="menu-container">
                    <h3 class="title-name"> Lunch </h3>
                    <table>
                        <th> Code </th> <th> Name </th><th> Food Category </th><th> Price </th> <th> Edit </th> <th> Delete </th>');
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> %3$s </td>
                                    <td> $ %4$s </td> 
                                    <td><button class="edit-btn">
                                                    <a href="editMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">edit</i>
                                                    </a></button></td>
                                    <td><button class="delete-btn">
                                                    <a href="deleteMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">delete_forever</i>
                    								</a></button></td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['FoodCategory'], $rc['PriceEach']);
                        }
            print('
                    </table>
                </div> <hr />
            ');
            
            
            
            $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_SESSION[Restaurant_id]' and FoodCategory='Tea buffet' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            print('
            <div class="menu-container">
                    <h3 class="title-name"> Tea buffet </h3>
                    <table>
                        <th> Code </th> <th> Name </th><th> Food Category </th><th> Price </th> <th> Edit </th> <th> Delete </th>');
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> %3$s </td>
                                    <td> $ %4$s </td> 
                                    <td><button class="edit-btn">
                                                    <a href="editMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">edit</i>
                                                    </a></button></td>
                                    <td><button class="delete-btn">
                                                    <a href="deleteMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">delete_forever</i>
                    								</a></button></td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['FoodCategory'], $rc['PriceEach']);
                        }
            print('
                    </table>
                </div> <hr />
            ');
            
            
            
            
            $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_SESSION[Restaurant_id]' and FoodCategory='Dinner' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            print('
            <div class="menu-container">
                    <h3 class="title-name"> Dinner </h3>
                    <table>
                        <th> Code </th> <th> Name </th><th> Food Category </th><th> Price </th> <th> Edit </th> <th> Delete </th>');
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> %3$s </td>
                                    <td> $ %4$s </td> 
                                    <td><button class="edit-btn">
                                                    <a href="editMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">edit</i>
                                                    </a></button></td>
                                    <td><button class="delete-btn">
                                                    <a href="deleteMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">delete_forever</i>
                    								</a></button></td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['FoodCategory'], $rc['PriceEach']);
                        }
            print('
                    </table>
                </div> <hr />
            ');
            
            
            
            $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_SESSION[Restaurant_id]' and FoodCategory='Drink' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            print('
            <div class="menu-container">
                    <h3 class="title-name"> Drink </h3>
                    <table>
                        <th> Code </th> <th> Name </th><th> Food Category </th><th> Price </th> <th> Edit </th> <th> Delete </th>');
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> %3$s </td>
                                    <td> $ %4$s </td> 
                                    <td><button class="edit-btn">
                                                    <a href="editMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">edit</i>
                                                    </a></button></td>
                                    <td><button class="delete-btn">
                                                    <a href="deleteMenu.php?FoodCode=%1$s">
                                                    <i class="material-icons">delete_forever</i>
                    								</a></button></td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['FoodCategory'], $rc['PriceEach']);
                        }
            print('
                    </table>
                </div> <hr />
            ');
            
            
            mysqli_free_result($rs);
            ?>

            <h1 style="text-align:center"> Add Menu </h1>
            <form method="POST" action="./addMenu.php">
                <label for="FoodCode"><i class="fa fa-user-o"></i> Food Code </label>
                <input type="text" name="FoodCode" id="FoodCode" required="required" /><br />

                <label for="FoodName"><i class="fa fa-user-o"></i> Name </label>
                <input type="text" name="FoodName" id="FoodName" required="required" /><br />

                <label for="FoodCategory"><i class="material-icons">attach_money</i> Category </label>
                <select id="FoodCategory" name="FoodCategory" tabindex="45" required="required">
                    <option value="Breakfast"> Breakfast </option>
                    <option value="Lunch"> Lunch </option>
                    <option value="Tea buffet"> Tea buffet </option>
                    <option value="Dinner"> Dinner </option>
                    <option value="Drink"> Drink </option>
                </select>
                <br /> <br />

                <label for="PriceEach"><i class="material-icons">attach_money</i> Price (Format: 1.00) </label>
                <input type="number" step="0.1" min="0" value="" pattern="\d+(\.+\d{2})?" name="PriceEach" id="PriceEach" required="required" />

                <label for="Description"><i class="fa fa-user-o"></i> Description </label>
                <textarea class="form-control" rows="5" id="Description" name="Description" style="width: 100%;"></textarea>

                <br /> <br />

                <center>
                    <input type="submit" class="btn" value="Add Menu">
                </center>
            </form>
        </div>

        <?php
            include_once('./footer.php');
        ?>
</body>

</html>