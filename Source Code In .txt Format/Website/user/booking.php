<?php
extract($_GET);
require_once '../checkLogin.php';
?>
<html>

<head>
    <link rel="stylesheet" href="../css/myStyle.css" />
    <link rel="stylesheet" href="../css/layout.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <title>Book Table</title>


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

        table {
            background-color: black;
            border: 1px black solid;
            border-collapse: collapse;
        }

        th {
            border: 1px outset silver;
            background-color: #DAA520;
            color: white;
        }

        tr {
            background-color: #FFFFCE;
            margin: 1px;
        }

        tr.striped {
            background-color: #FFFF66;
        }

        tr.over {
            background-color: gold;
        }

        td {
            padding: 1px 8px;
        }

        .jumbotron {

            text-align: center;
        }

        td {
            padding: .4em;
        }

        .comName {
            width: 70%;
            text-align: 'left';
        }

        table {
            width: 100%;
            table-layout: fixed;
        }
    </style>
    <script>
        window.onload = function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            today = yyyy + '-' + mm + '-' + dd;
            var startDate = document.getElementById("startDate");
            var endDate = document.getElementById("endDate");
            startDate.min = today;
            endDate.min = today;
        }
    </script>
</head>

<body>
    <div id="flex-container">
        <div id="header" align="center">
            <div class="menu">
                <ul>
                    <li><a href="../index.php"> Home </a></li>
                    <li><a href="./booking.php">Book Table</a></li>

                    <li>
                        <a href="./bookinghistory.php">View Book History</a>
                    </li>



                    <li style="float:right"><a href="../logout.php">Logout</a></li>
                    <li style="float:right">
                        <a href="../changePassword.php">User Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <br />
        <br />
        <div id="main">


            <?php
            require_once('../conn.php');

            $sql = "SELECT * FROM restauranttable WHERE status = 'available' Order By TableNum ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));


            while ($rc = mysqli_fetch_assoc($rs)) {
            }


            ?>

            <center>
                <h1>Book Table</h1>
            </center>
            <form method="POST" action="bookedcheck.php">
                <label for="TableNumber"><i class="fa fa-user-o"></i> Number of people </label>
                <select id='tablenum' name='tablenum'>
                    <?php
                    $sql = "SELECT TableNum FROM restauranttable WHERE status = 'available' Order By TableNum ASC";
                    $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    while ($rc = mysqli_fetch_assoc($rs)) {
                        printf('<option>%s</option>', $rc['TableNum']);
                    }
                    ?>
                </select><br /> <br />
                <label for="TableNumber"><i class="fa fa-calendar"></i> ReservationDate </label>
                <input type="date" name="sDate" id="startDate" oninvalid="this.setCustomValidity('Please set the start date!')" oninput="this.setCustomValidity('')" required="required">
                <br /> <br />
                <label for="TableNumber"><i class="fa fa-clock-o"></i> ReservationTime </label>
                <select id='sTime' name='sTime'>
                    <option>13:00:00</option>
                    <option>15:00:00</option>
                    <option>17:00:00</option>
                    <option>19:00:00</option>
                    <option>21:00:00</option>
                </select><br /> <br />
                <label for="TableNumber"><i class="fa fa-credit-card"></i> Payment Method </label>
                <input type='radio' name='paymenttype' value='Paypal'> <i class="fa fa-credit-card-alt"></i> Credit Card &nbsp;&nbsp; <input type='radio' name='paymenttype' value='Cash'> <i class="fa fa-money"></i> Cash
                <br /><br />
                <font color='red'>**You should choose one method to pay after you finished your service</font>
                <br /> <br />
                <center>
                    <input type="submit" class="btn" value="Book Table">
                </center>
            </form>

        </div>


        <?php
            include_once('/var/www/html/FYP/template/footer.php');
        ?>

    </div>
</body>

</html>