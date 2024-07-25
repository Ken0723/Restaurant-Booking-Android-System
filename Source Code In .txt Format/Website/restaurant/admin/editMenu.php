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

    <title>Edit Menu</title>
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
                <h1> Edit Menu </h1>
            </center>

            <?php
            require_once('../../conn.php');
            extract($_GET);
            $sql = "SELECT * FROM fooditem Where RestaurantID='$_SESSION[Restaurant_id]' and Code='$FoodCode'";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
            $FoodCode = $row['Code'];
            $FoodName = $row['Name'];
            $FoodCategory = $row['FoodCategory'];
            $PriceEach = $row['PriceEach'];
            $Description = $row['Description'];
            ?>
            <form method="POST" action="./updateMenu.php">
                <label for="FoodCode"><i class="fa fa-user-o"></i> Food Code </label>
                <input type="text" value="<?= $FoodCode ?>" oninput="checkCode(this);" name="FoodCode" id="FoodCode" required="required" /><br />

                <label for="FoodName"><i class="fa fa-user-o"></i> Name </label>
                <input type="text" value="<?= $FoodName ?>" oninput="checkName(this);" name="FoodName" id="FoodName" required="required" /><br />

                <label for="FoodCategory"><i class="material-icons">attach_money</i> Category </label>
                <select id="FoodCategory" name="FoodCategory" tabindex="45" onchange="checkCategory(this);" required="required">
                    <option value="Breakfast" <?=$FoodCategory == 'Breakfast' ? ' selected="selected"' : '';?> > Breakfast </option>
                    <option value="Lunch" <?=$FoodCategory == 'Lunch' ? ' selected="selected"' : '';?> > Lunch </option>
                    <option value="Tea buffet" <?=$FoodCategory == 'Tea buffet' ? ' selected="selected"' : '';?> > Tea buffet </option>
                    <option value="Dinner" <?=$FoodCategory == 'Dinner' ? ' selected="selected"' : '';?> > Dinner </option>
                    <option value="Drink" <?=$FoodCategory == 'Drink' ? ' selected="selected"' : '';?> > Drink </option>
                </select>
                <br /> <br />

                <label for="PriceEach"><i class="material-icons">attach_money</i> Price (Format: 1.00) </label>
                <input type="number" value="<?= $PriceEach ?>" step="0.1" min="0" value="" pattern="\d+(\.\d{2})?" name="PriceEach" id="PriceEach" required="required" />

                <label for="Description"><i class="fa fa-user-o"></i> Description </label>
                <textarea class="form-control" rows="5" id="Description" name="Description" style="width: 100%;"><?= $Description ?></textarea>

                <input type="hidden" id="ck_FoodCode" name="ck_FoodCode" value="0" />
                <input type="hidden" id="ck_FoodName" name="ck_FoodName" value="0" />
                <input type="hidden" id="ck_FoodCategory" name="ck_FoodCategory" value="0" />

                <input type="hidden" id="_FoodCode" name="_FoodCode" value="<?php echo $FoodCode; ?>" />
                <br /> <br />

                <center>
                    <input type="submit" class="btn" value="Submit">
                </center>
            </form>
        </div>

        <?php
            include_once('./footer.php');
        ?>

    <script>
        var _FoodCode = '<?php echo $FoodCode; ?>';
        var _FoodName = '<?php echo $FoodName; ?>';
        var _FoodCategory = '<?php echo $FoodCategory; ?>';

        function checkCode(code) {
            if (_FoodCode !== code.value) {
                $('#ck_FoodCode').val(1);
            } else {
                $('#ck_FoodCode').val(0);
            }
        }

        function checkName(name) {
            if (_FoodName !== name.value) {
                $('#ck_FoodName').val(1);
            } else {
                $('#ck_FoodName').val(0);
            }
        }

        function checkCategory(ca) {
            if (_FoodCategory !== ca.value) {
                $('#ck_FoodCategory').val(1);
            } else {
                $('#ck_FoodCategory').val(0);
            }
        }
    </script>
</body>

</html>