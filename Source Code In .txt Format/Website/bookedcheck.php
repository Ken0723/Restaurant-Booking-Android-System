<?php

session_start();
require_once('./conn.php');
extract($_POST);
	$userEmail = $_SESSION['login_user'];
    $sql = "SELECT * FROM user where Email = '$userEmail'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $rc = mysqli_fetch_assoc($result);
	$UserID = $rc['ID'];
	$sql2 = "SELECT * FROM customer where UserID = '$UserID'";
    $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
    $rc2 = mysqli_fetch_assoc($result2);
	$CustomerID = $rc2['ID'];
	$sql4 = "SELECT * FROM restauranttable where TableNum = '$tablenum'";
    $result4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
    $rc4 = mysqli_fetch_assoc($result4);
	$TableID = $rc4['ID'];
	$sql3 = "INSERT INTO reservation VALUES (null, $RestaurantID, '$CustomerID', '$TableID', '$sDate', '$sTime', 'Booked')";
	$result3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
	$sql5 = "update restauranttable set status='Booked' where TableNum='$tablenum'";
	$result5 = mysqli_query($conn, $sql5) or die(mysqli_error($conn));
	echo '<script language="javascript"> alert("You have booked successfully!");</script>';
	echo '<script language="javascript"> window.location.href=\'./Restaurant.php?restaurantID=$RestaurantID\';</script>';


mysqli_close($conn);
