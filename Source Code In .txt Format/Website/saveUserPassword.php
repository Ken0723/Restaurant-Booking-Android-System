<?php

require_once('./checkLogin.php');
require_once('./conn.php');
extract($_POST);

$userEmail = $_SESSION["login_user"];

$sql = "SELECT * FROM user where Email = '$userEmail'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$rc = mysqli_fetch_assoc($result);

if ($tfOldPassword != $rc['Password']) {
    echo '<script language="javascript"> alert("Old password isn\'t valid"); </script>';
} else if ($tfNewPassword != $tfRePassword) {
    echo '<script language="javascript"> alert("Password confirmation doesn\'t match the password"); </script>';
} else {

    $sql = "Update user Set Password='$tfNewPassword' Where Email='$userEmail'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
        echo '<script language="javascript"> alert("UPDATE password Success");</script>';
    } else {
        echo '<script language="javascript"> alert("UPDATE Item fail, please check the type of value");</script>';
    }
}
echo '<script language="javascript"> window.location.href=\'./changePassword.php\'; </script>';
mysqli_free_result($result);
