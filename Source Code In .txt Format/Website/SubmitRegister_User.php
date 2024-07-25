<?php

session_start();
require_once('./conn.php');
extract($_POST);
$isExists = FALSE;
$codition = "";
if (strlen($regEmail) > 0) {
    $codition = "where email='$regEmail'";
} else {
    $codition = "";
}
$sql = "SELECT * FROM user $codition ;";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row != "") {
    $isExists = TRUE;
} else {
    $isExists = FALSE;
}

if (!$isExists) {
    $sql = "INSERT INTO user VALUES (null, '$regEmail', '$regPassword', '0')";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $sql = "SELECT * FROM user $codition ;";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $userID = $row['ID'];

    $sql = "INSERT INTO customer VALUES (null, '$userID', '$regLastname', '$regFirstname', '$regPhone', '$regAddress')";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    echo '<script language="javascript"> alert("Congratulations! You have registered successfully!");</script>';
    echo '<script language="javascript"> window.location.href=\'./login.html\';</script>';
} else {
    echo '<script language="javascript"> alert("Email already exists! Please enter a new Email!");</script>';
    echo '<script language="javascript"> window.location.href=\'./register.php\';</script>';
}

mysqli_close($conn);
