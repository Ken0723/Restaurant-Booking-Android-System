<?php

require_once('../checkLogin.php');
require_once('../conn.php');

$sql = "Update orders Set status='Apply to cancel' where orderID=$_GET[orderID];";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
    echo '<script language="javascript"> alert("Apply to cancel Success")</script>';
    echo '<script language="javascript"> window.location.href=\'./viewOrders.php\'; </script>';
} else {
    echo '<script language="javascript"> alert("Apply to cancel fail, please check")</script>';
}
?>