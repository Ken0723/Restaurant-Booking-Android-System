<?php

require_once('./checkLogin.php');
require_once('./conn.php');
extract($_POST);
$userEmail = $_SESSION['login_user'];
$userRole = $_SESSION['role'];
$userID = $_SESSION["user_id"];
$isSuccuss = false;

$sql = "SELECT * FROM user Where email='$userEmail'";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
    $isSuccuss = true;
}
if ($_SESSION["group_id"] > 0) {
    $sql = "Update employee Set LastName='$tfLastName', FirstName='$tfFirstName', phone='$tfPhoneNumber', address='$tfAddress' Where UserID='$userID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
        $isSuccuss = true;
    }
} else {
    $sql = "Update customer Set LastName='$tfLastName', FirstName='$tfFirstName', phone='$tfPhoneNumber', address='$tfAddress' Where UserID='$userID'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
        $isSuccuss = true;
    }
}


if ($isSuccuss) {
    echo '<script language="javascript"> alert("UPDATE profile Success")</script>';
    echo '<script language="javascript"> window.location.href=\'./viewUserProfile.php\'; </script>';
} else {
    echo '<script language="javascript"> alert("UPDATE profile fail, please check the type of value")</script>';
    echo '<script language="javascript"> window.location.href=\'./viewUserProfile.php\'; </script>';
}
