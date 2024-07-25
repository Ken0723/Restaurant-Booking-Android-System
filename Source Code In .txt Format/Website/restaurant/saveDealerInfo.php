<?php

require_once('../checkLogin.php');
require_once('../conn.php');
extract($_POST);

$sql = "Update dealer Set name='$tfName', phoneNumber='$tfPhoneNumber', address='$tfAddress' Where dealerID='$tfDealerID'";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
    echo '<script language="javascript"> alert("UPDATE profile Success")</script>';
    echo '<script language="javascript"> window.location.href=\'./viewDealer.php\'; </script>';
} else {
    echo '<script language="javascript"> alert("UPDATE Item fail, please check the type of value")</script>';
    echo '<script language="javascript"> window.location.href=\'./viewDealer.php\'; </script>';
}
?>