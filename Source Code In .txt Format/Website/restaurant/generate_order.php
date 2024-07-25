<?php

require_once('../conn.php');
//extract($_POST);
$sql = "select MAX(orderID) from orders";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);
$new = $row['MAX(orderID)'];
$new = ((int) $new) + 1;



$sql = "SELECT * FROM part WHERE stockStatus='Available';";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$isSelectPart = FALSE;

while ($rc = mysqli_fetch_assoc($rs)) {
	if(!isset($_POST['quantity'.$rc['partNumber']])){
	 continue;}
      $Quantity = $_POST['quantity'.$rc['partNumber']];
	  
	 
  
    $Price = (float) $Quantity * $rc['stockPrice'];

    if ($Quantity != 0) {
        $isSelectPart = TRUE;
        $insertOrderPart[] = "INSERT INTO orderpart VALUES ($new, $rc[partNumber], $Quantity, $Price)";
    }
}

if ($isSelectPart) {
    session_start();
    $dealerID = $_SESSION['login_user'];
    $sql = "select * from dealer where dealerID = '$dealerID'";
    $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $rc = mysqli_fetch_assoc($rs);
    $dealerAddress = $rc['address'];

    $sql = "select MAX(orderID) from orders";
    $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $rc = mysqli_fetch_assoc($rs);

    $orderAddress = ($_POST['tfDeliveryAddress'] != "") ? $_POST['tfDeliveryAddress'] : $dealerAddress;
    $insertOrders = "INSERT INTO orders(dealerID, orderDate, deliveryAddress, status) VALUES ('$dealerID', now(), '$orderAddress', 'In processing')";
    mysqli_query($conn, $insertOrders) or die(mysqli_error($conn));
    for ($i = 0; $i < count($insertOrderPart); $i++) {
        mysqli_query($conn, $insertOrderPart[$i]) or die(mysqli_error($conn));
    }

    if (mysqli_affected_rows($conn) > 0) {
        echo '<script language="javascript"> alert("Make Order Success")</script>';
        header("Refresh:0; url=makeOrders.php");
    } else {
        echo '<script language="javascript"> alert("Add Item fail")</script>';
    }
} else {
    echo '<script language="javascript"> alert("The part of this order has not yet been selected.")</script>';
    header("Refresh:0; url=makeOrders.php");
}
?>