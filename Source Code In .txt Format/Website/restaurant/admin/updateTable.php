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

    <link rel="stylesheet" href="/FYP/canvas/table.css">
    <title>Update Table</title>
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
    </style>

    <script>
        $(document).ready(function() {
            $(".changeStatus").on('change', function() {
                var tableNumber = $(this).parents("td").siblings("td:eq(1)").html();
                var tableStatus = $(this).val();

                $.ajax({
                    async: false,
                    type: "POST", //傳送方式
                    url: "./updateTableStatus.php", //傳送目的地
                    dataType: "html", //資料格式
                    data: { //傳送資料
                        tableNumber: tableNumber, //表單欄位 ID nickname
                        tableStatus: tableStatus //表單欄位 ID gender
                    },
                    success: function(response) {
                        
                        location.reload();
                    },
                    error: function(jqXHR) {
                        alert('Ajax request Error' + jqXHR);
                    }
                });

            });
        });
    </script>

</head>

<body>
    <?php
            include_once('./header.php');
        ?>
        <br />
        <br />
        <div id="main">
            <center>
                <h1>Update Table</h1>
                
                <!--<canvas id="canvas" width="1000" height="550"></canvas>-->
            </center>
            
            <script src="/FYP/canvas/table.js"></script>
            <?php
            require_once('../../conn.php');

            $sql = "SELECT * FROM restauranttable WHERE RestaurantID='$_SESSION[Restaurant_id]' Order By TableNum ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            echo '<table border="1" width="100%">
	<tr>
	      <th>Delete</th><th> Table Number </th><th> Table Size </th><th> Table Status </th> <th> Change Status </th></tr>';

            while ($rc = mysqli_fetch_assoc($rs)) {

                if ($rc['Status'] == "Available") {
                    $status = '<select class="changeStatus" id="TableStatus%1$s" name="TableStatus%1$s">
                    <option value="Available" selected>Available</option>
                    <option value="Calling">Calling</option>
                    <option value="Seated">Seated</option>
                    <option value="Unavailable">Unavailable</option>
                </select>';
                } else if ($rc['Status'] == "Calling") {
                    $status = '<select class="changeStatus"  id="TableStatus%1$s" name="TableStatus%1$s">
                    <option value="Available">Available</option>
                    <option value="Calling" selected>Calling</option>
                    <option value="Seated">Seated</option>
                    <option value="Unavailable">Unavailable</option>
                </select>';
                } else if ($rc['Status'] == "Seated") {
                    $status = '<select class="changeStatus"  id="TableStatus%1$s" name="TableStatus%1$s">
                    <option value="Available">Available</option>
                    <option value="Calling">Calling</option>
                    <option value="Seated" selected>Seated</option>
                    <option value="Unavailable">Unavailable</option>
                </select>';
                } else if ($rc['Status'] == "Unavailable") {
                    $status = '<select class="changeStatus"  id="TableStatus%1$s" name="TableStatus%1$s">
                    <option value="Available">Available</option>
                    <option value="Calling">Calling</option>
                    <option value="Seated">Seated</option>
                    <option value="Unavailable" selected>Unavailable</option>
                </select>';
                } else {
                    
                }
                printf('<tr>
                <td><input type="button" value="Delete" onclick="window.location.href=\'delete_table.php?TableNumber=%1$d\';" class="btn" %2$s /></td>
        <td> %1$s </td>
        <td> %2$s </td>
        <td> %3$s </td> 
        <td> %4$s </td>
	</tr>', $rc['TableNum'], $rc['TableSize'], $rc['Status'], $status);
            }

            echo '</table>';

            $sql = "SELECT * FROM restauranttable WHERE RestaurantID='$_SESSION[Restaurant_id]' Order By TableNum ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            while ($rc = mysqli_fetch_assoc($rs))
                $maxTableNum = $rc['TableNum'];
            mysqli_free_result($rs);
            ?>

            <form method="POST" action="saveTableInfo.php">
                <label for="TableNumber"><i class="fa fa-user-o"></i> Table Number </label>
                <input type="number" step="1" min="1" value="<?= (int) $maxTableNum + 1 ?>" name="TableNumber" id="TableNumber" /><br />

                <label for="TableSize"><i class="material-icons">attach_money</i> Table Size </label>
                <input type="number" step="1" min="1" value="1" name="TableSize" id="TableSize" required><br /> <br />

                <label for="TableStatus"><i class="material-icons">attach_money</i> Table Status </label>
                <select id="TableStatus" name="TableStatus">
                    <option value="Available">Available</option>
                    <option value="Calling">Calling</option>
                    <option value="Seated">Seated</option>
                    <option value="Unavailable">Unavailable</option>
                </select><br /> <br />

                <center>
                    <input type="submit" class="btn" value="Add Table">
                </center>
            </form>
        </div>

        <?php
            include_once('./footer.php');
        ?>
</body>

</html>