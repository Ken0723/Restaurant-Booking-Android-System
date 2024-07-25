<?php
extract($_GET);
require_once('../../checkLogin.php');
require_once('../../conn.php');

$sql = "DELETE FROM fooditem WHERE Code='$FoodCode';";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
    echo '<script language="javascript"> alert("Delete Success");</script>';
} else {
    echo '<script language="javascript"> alert("Delete Fail, please check the type of value");</script>';
}

mysqli_close($conn);
echo "<script type='text/javascript'>window.location.href='./menu.php';</script>";
