<?php
require_once('../../checkLogin.php');
require_once('../../conn.php');
extract($_POST);
$sql = "SELECT * FROM fooditem Where RestaurantID='$_SESSION[Restaurant_id]' and Code='$FoodCode'";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
$isExists = FALSE;

if ($row != "") {
	$isExists = TRUE;
	echo '<script language="javascript"> alert("This FoodCode already exist!");</script>';
	echo "<script type='text/javascript'>window.location.href='./menu.php';</script>";
} else {
	$isExists = FALSE;
}

$sql = "SELECT * FROM fooditem Where FoodCategory='$FoodCategory' And Name='$FoodName'";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);

if ($row != "") {
	$isExists = TRUE;
	echo '<script language="javascript"> alert("This FoodCategory and FoodName already exist!");</script>';
	echo "<script type='text/javascript'>window.location.href='./menu.php';</script>";
} else {
	$isExists = FALSE;
}
if (!$isExists) {
	$sql = "INSERT INTO fooditem VALUES (null, '$_SESSION[Restaurant_id]', '$FoodCode', '$FoodName', '$FoodCategory', $PriceEach, '$Description');";

	mysqli_query($conn, $sql) or die(mysqli_error($conn));
	if (mysqli_affected_rows($conn) > 0) {
		echo '<script language="javascript"> alert("UPDATE Success");</script>';
	} else {
		echo '<script language="javascript"> alert("UPDATE Fail, please check the type of value");</script>';
	}
} else {
	echo '<script language="javascript"> alert("This FoodCategory and FoodName already exist!");</script>';
}
mysqli_free_result($rs);
mysqli_close($conn);
echo "<script type='text/javascript'>window.location.href='./menu.php';</script>";
