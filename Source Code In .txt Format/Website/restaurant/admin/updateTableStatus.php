<?php
require_once('../../conn.php');
extract($_POST);

$sql = "Update restauranttable Set Status='$tableStatus' Where TableNum='$tableNumber'";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
    echo '<script language="javascript"> alert("UPDATE Status Success");</script>';
} else {
    echo '<script language="javascript"> alert("UPDATE Status Fail, please check the type of value");</script>';
}

echo '<script language="javascript"> window.location.href=\'./updateTable.php\'; </script>';
