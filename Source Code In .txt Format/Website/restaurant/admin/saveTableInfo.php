<?php

session_start();
require_once('../../conn.php');
extract($_POST);
$isExists = FALSE;

$sql = "SELECT * FROM restauranttable where RestaurantID='$_SESSION[Restaurant_id]' and TableNum='$TableNumber' ;";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row != "") {
	$isExists = TRUE;
} else {
	$isExists = FALSE;
}

if (!$isExists) {
	$sql = "INSERT INTO restauranttable VALUES (null, '$_SESSION[Restaurant_id]','$TableNumber', '$TableSize', '$TableStatus')";
	$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

	echo '<script language="javascript"> alert("You have updated successfully!");</script>';
	echo '<script language="javascript"> window.location.href=\'./updateTable.php\';</script>';
} else {
	echo '<script language="javascript"> alert("Table Number already exists! Please enter a new Table Number!");</script>';
	echo '<script language="javascript"> window.location.href=\'./updateTable.php\';</script>';
}

mysqli_close($conn);
