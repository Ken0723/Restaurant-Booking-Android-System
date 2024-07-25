<?php

session_start();
require_once('./conn.php');
extract($_POST);
$sql = "SELECT * FROM user where email='" . $username . "' and password='" . $password . "'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$active = $row['Email'];
$gid = $row['GroupID'];
$uid = $row['ID'];
$count = mysqli_num_rows($result);
if ($count == 1) {
    $json = file_get_contents('./groupid.json');
    $obj = json_decode($json, true);

    if (isset($obj["groupid"])) {
        $userGroup = $obj["groupid"][$gid];

        $_SESSION['login_user'] = $username;
        $_SESSION["group_id"] = $gid;
        $_SESSION["role"] = $userGroup;
        $_SESSION["user_id"] = $uid;
        
        echo "<script type='text/javascript'>alert('login success,welcome!');</script>";
        if ($userGroup == "user") {
            $sql = "SELECT * FROM customer where UserID=$uid";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $_SESSION["customer_id"] = $row['ID'];
            echo "<script type='text/javascript'>window.location.href='index.php';</script>";
        } else if ($userGroup == "res") {
            $sql = "SELECT * FROM employee WHERE UserID='$uid';";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            $_SESSION["Restaurant_id"] = $row["RestaurantID"];
            echo "<script type='text/javascript'>window.location.href='index.php';</script>";
        } else if ($userGroup == "resadmin") {
            $sql = "SELECT * FROM employee WHERE UserID='$uid';";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            $_SESSION["Restaurant_id"] = $row["RestaurantID"];
            echo "<script type='text/javascript'>window.location.href='index.php';</script>";
        } else if ($userGroup == "admin") {
            echo "<script type='text/javascript'>window.location.href='index.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('groupid error');";
        }
    } else {
        echo "<script type='text/javascript'>alert('groupid.json not found');window.location.href='login.html';</script>";
    }
} else {
    $error = "Your Login Name or Password is invalid";
    echo "<script type='text/javascript'>alert('$error');</script>";
    echo '<script language="javascript"> window.location.href=\'./login.html\'; </script>';
}
mysqli_free_result($result);
mysqli_close($conn);
