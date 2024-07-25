<?php
require_once('../../checkLogin.php');
require_once('../../conn.php');

extract($_GET);

$sql = "SELECT * FROM restauranttable Where TableNum='$TableNumber'";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);

$TableID = $row['ID'];
$sql = "SELECT * FROM reservation Where TableID='$TableID'";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
$isExists = FALSE;

if ($row != "") {
	$isExists = TRUE;
	$sql = "DELETE FROM reservation WHERE TableID=$TableID;";
	mysqli_query($conn, $sql) or die(mysqli_error($conn));
} else {
	$isExists = FALSE;
}

$sql = "DELETE FROM restauranttable WHERE TableNum=$TableNumber;";
mysqli_query($conn, $sql) or die(mysqli_error($conn));

if (mysqli_affected_rows($conn) > 0) {

	echo '<script language="javascript"> alert("Delete successfully!");</script>';
	echo '<script language="javascript"> window.location.href=\'./updateTable.php\';</script>';
} else {
	echo '<script language="javascript"> alert("Delete Error");</script>';
	echo '<script language="javascript"> window.location.href=\'./updateTable.php\';</script>';
}

mysqli_close($conn);
