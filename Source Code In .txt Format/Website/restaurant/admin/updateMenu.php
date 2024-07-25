<?php
extract($_POST);
require_once('../../checkLogin.php');
require_once('../../conn.php');

$isExists = FALSE;

if ($ck_FoodCode == "1") {
	$sql = "SELECT * FROM fooditem Where Code='$FoodCode'";
	$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);

	if ($row != "") {
		$isExists = TRUE;
		echo '<script language="javascript"> alert("This FoodCode already exist!");</script>';
		echo "<script type='text/javascript'>window.location.href='./menu.php';</script>";
	} else {
		$isExists = FALSE;
	}
}

if ($ck_FoodName == "1" || $ck_FoodCategory == "1") {
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
}

if (!$isExists) {

	$sql = "Update fooditem Set Code='$FoodCode', Name='$FoodName', FoodCategory='$FoodCategory', PriceEach='$PriceEach', Description='$Description' Where Code='$_FoodCode'";
	mysqli_query($conn, $sql) or die(mysqli_error($conn));
	if (mysqli_affected_rows($conn) > 0) {
		echo '<script language="javascript"> alert("UPDATE Success");</script>';
	} else {
		echo '<script language="javascript"> alert("UPDATE Fail, please check the type of value");</script>';
	}
} else {
	echo '<script language="javascript"> alert("This FoodCategory and FoodName already exist!");</script>';
}
mysqli_close($conn);
echo "<script type='text/javascript'>window.location.href='./menu.php';</script>";
