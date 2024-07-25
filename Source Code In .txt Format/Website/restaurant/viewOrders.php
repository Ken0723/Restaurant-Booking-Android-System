<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>View orders</title>
    <link rel="stylesheet" href="../css/style.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <head>

        <script>

            function search() {
                if (document.getElementById("codi").value != "") {
                    location.replace("viewOrders.php?orderID=" + document.getElementById("codi").value);
                } else {
                    location.replace("viewOrders.php");
                }
            }
        </script>
        <style>
            #search {
                width: 5em; 
            }

            input[type=text] {
                width: 350px;
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

    <center>
        <input type="text" id="codi" placeholder="Enter OrderID for search" size="75%" />
        <input type="button" id="searchtext" value="search" onClick="search();" />
        <br><br>
    </center>
    <?php
    if (isset($_GET["orderID"])) {
        $codition = "orderID=$_GET[orderID] AND";
    } else {
        $codition = "";
    }
    require_once('../conn.php');

    //session_start();
    $dealerID = $_SESSION['login_user'];

    $sql = "SELECT * FROM orders WHERE $codition dealerID='$dealerID' order by orderDate DESC;";
    $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //printf($form, $rc['orderID'], $rc['deliveryAddress'], $rc['orderDate'], $rc['status'], $rc['orderID']);

    echo '<table border="1" width="100%">
	<tr>
	      <th>Cancel</th><th>Delete</th><th>Order ID</th><th>Address</th><th>Order Date</th><th>Status</th><th>Confirm</th><th>Detail</th></tr>';

    while ($rc = mysqli_fetch_assoc($rs)) {

        printf('<td><input type="button" value="Cancel order" onclick="window.location.href=\'cancel_order.php?orderID=%1$d\';" class="btn" %2$s /></td><td><input type="button" value="Delete order" onclick="window.location.href=\'delete_order.php?orderID=%1$d\';" class="btn" %3$s /></td>
		<td> %1$d </td><td> %4$s </td><td> %5$s </td><td> %6$s </td><td><input type="button" value="Completed order" onclick="window.location.href=\'completed_order.php?orderID=%1$d\';" class="btn" %7$s /></td><td><input type="button" value="View" onclick="window.location.href=\'./viewOrdersDetail.php?orderID=%1$d\';" class="btn" /></td>
	</tr>', $rc['orderID'], ($rc['status'] == 'In processing' ? '' : 'disabled="disabled"'), ($rc['status'] == 'Canceled' ? '' : 'disabled="disabled"'), $rc['deliveryAddress'], $rc['orderDate'], $rc['status'], ($rc['status'] == 'Delivery' ? '' : 'disabled="disabled"'));
    }

    echo '</table>';

    mysqli_free_result($rs);
    ?>
</body>
</html>