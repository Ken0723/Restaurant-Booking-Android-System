<?php
session_start();
require_once('../../conn.php');
extract($_POST);

##### 預設密碼長度為 8 位
function random_password($length=8) {  
    ##### 隨機密碼可能包含的字符
    $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-+=_,!@$#*%<>[]{}";
    $password = substr(str_shuffle($str), 0, $length);
    return $password;
}
 
##### 產生 10 位的密碼
$password = random_password(10);

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
    $sql = "SELECT * FROM employee WHERE UserID='$_SESSION[user_id]';";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $resID = $row["RestaurantID"];
    
    $sql = "INSERT INTO user VALUES (null, '$regEmail', '$password', 1)";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $sql = "SELECT * FROM user $codition ;";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $userID = $row['ID'];

    $sql = "INSERT INTO employee VALUES (null, $resID, $userID, '$regLastname', '$regFirstname', null, null, null)";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    


    echo '<script language="javascript"> alert("The company or restaurant has been successfully registered!");</script>';
    $ourOrganization="2020 Group 3";
    $subject = "PPM System Account confirmation";
    $content = "Dear $regLastname $regFirstname%0A%0A";
    $content .= "Thank you for choosing PPM System!%0A%0A";
    $content .= "Please confirm your account and password.%0A%0A";
    $content .= "Here is your account number and password%0A";
    $content .= "Account: $regEmail%0A";
    $content .= "Password: $password%0A%0A%0A";
    $content .= "For other technical questions and support, please contact us at 180162421@stu.vtc.edu.hk.%0A%0A%0A";
    $content .= "We look forward to working with you!%0A%0A%0A";
    $content .= "Best regards,%0A";
    $content .= "$ourOrganization team%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A";
    
    echo "<script language=\"javascript\"> setTimeout(function(){
        window.location = './CreateEmployeeAccount.php';
   }, 1000); </script>";
    echo "<script language=\"javascript\"> window.location.href='mailto:$regEmail?subject=$subject&body=$content'; </script>";

} else {
    echo '<script language="javascript"> alert("Email already exists! Please enter a new Email!");</script>';
    echo '<script language="javascript"> window.location.href=\'./CreateEmployeeAccount.php\';</script>';
}

mysqli_close($conn);
?>
