<?php

require_once('../checkLogin.php');
require_once('../conn.php');
extract($_POST);
//session_start();
//$email=$_SESSION["login_user"];

$sql = "Update orders Set status='Completed' where orderID=$_GET[orderID];";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
    echo '<script language="javascript"> alert("Confirm order Success")</script>';
    echo '<script language="javascript"> window.location.href=\'./viewOrders.php\'; </script>';
} else {
    echo '<script language="javascript"> alert("Confirm order fail, please check the type of value")</script>';
}
?>