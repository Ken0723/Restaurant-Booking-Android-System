<?php

require_once('../checkLogin.php');
require_once('../conn.php');
$sql = "DELETE FROM orderpart WHERE orderID=$_GET[orderID];";
mysqli_query($conn, $sql) or die(mysqli_error($conn));

$sql = "DELETE FROM orders WHERE orderID=$_GET[orderID];";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
    echo '<script language="javascript"> alert("Delete order records Success")</script>';
    echo '<script language="javascript"> window.location.href=\'./viewOrders.php\'; </script>';
} else {
    echo '<script language="javascript"> alert("Apply fail, please check!")</script>';
    echo '<script language="javascript"> window.location.href=\'./viewOrders.php\'; </script>';
}
mysqli_close($conn);
mysqli_free_result($result);
?>