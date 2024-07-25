<?php

require_once('../../checkLogin.php');
require_once('../../conn.php');
extract($_POST);
$userEmail = $_SESSION['login_user'];
$userRole = $_SESSION['role'];
$userID = $_SESSION["user_id"];
$isSuccuss = false;

$sql = "Update restaurant Set Name='$tfRestaurantName', District='$tfRestaurantDistrict', Address='$tfRestaurantAddress', Latitude='$tfLatitude', Longitude='$tfLongitude', Phone='$tfRestaurantPhoneNumber', Enable=$activate Where ID='$tfRestaurantID'";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
    $isSuccuss = true;
}

if ($isSuccuss) {


    move_uploaded_file($_FILES["file"]["tmp_name"],"../../upload/restaurant-photo/restaurant-photo-ID-$tfRestaurantID");

    echo '<script language="javascript"> alert("UPDATE Information Success")</script>';
    echo '<script language="javascript"> window.location.href=\'./updateRestaurantInformation.php\'; </script>';

} else {
    echo '<script language="javascript"> alert("UPDATE Information fail, please check the type of value")</script>';
    echo '<script language="javascript"> window.location.href=\'./updateRestaurantInformation.php\'; </script>';
}
