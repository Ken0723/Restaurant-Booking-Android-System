<?php
require_once('./conn.php');
extract($_POST);

$sql = "INSERT INTO comments 
 VALUES (null, '$RestaurantID', '$UserID', '$Name', '$Comment', CONVERT_TZ(NOW(),'+00:00','+08:00'), '$Rating')";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {

    echo '<script language="javascript"> alert("Comment Success");</script>';
} else {
    echo '<script language="javascript"> alert("Comment Fail, please check the type of value");</script>';
}

echo '<script language="javascript"> window.location.href=\'./Restaurant.php?restaurantID=$RestaurantID\'; </script>';
?>