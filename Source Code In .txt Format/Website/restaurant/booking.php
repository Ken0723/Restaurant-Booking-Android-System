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

    <title>Book History</title>
    

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
        $(document).ready(function() {
            $('tr:odd').addClass('striped');

            $('tr').mouseover(function() {
                $(this).addClass('over');
            }).mouseout(function() {
                $(this).removeClass('over');
            });
        });
    </script>
</head>
<body>
    <div id="flex-container">
        <div id="header" align="center">
            <div class="menu">
                <ul>
                    <li><a href="../index.php"> Home </a></li>
                    <li><a href="./menu.php">Menu</a></li>

                    <li>
                        <a href="./booking.php">View Reservation</a>
                    </li>

                    <li><a href="./viewTable.php">Table</a></li>

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
            <center>
                <h1> Customers Booking </h1>
            </center>

            <?php
            require_once('../conn.php');

            $sql = "SELECT * FROM reservation Order By reservationDate ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            echo '<table border="1" width="100%">
	<tr>
	      <th> TableNumber </th><th> ReservationDate </th><th> ReservationTime </th><th> Status </th> </tr>';

            while ($rc = mysqli_fetch_assoc($rs)) {
				$Table = $rc['TableID'];
$sql4 = "SELECT * FROM restauranttable where ID = '$Table'";
    $result4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
    $rc4 = mysqli_fetch_assoc($result4);
	$TableID = $rc4['TableNum'];

                printf('<tr>

        <td> %2$s </td>
        <td> %3$s </td>
        <td> %4$s </td> 
		<td> %5$s </td> 
    </tr>', $rc['RestaurantID'], $TableID, $rc['ReservationDate'], $rc['ReservationsTime'], $rc['Status']);
            }

            echo '</table>';
            mysqli_free_result($rs);
            ?>

        </div>

        <div id="footer">
            @2020 Group 3. All rights reserved.
        </div>

    </div>
</body>

</html>