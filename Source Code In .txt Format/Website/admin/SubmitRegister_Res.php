<?php
session_start();
require_once('../conn.php');
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
    $sql = "INSERT INTO restaurant VALUES (null, '$regResname', null, null, null, '22.34077157257136', '114.19397592544557', 0)";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $sql = "SELECT MAX(ID) FROM restaurant;";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    $resID = $row[0];
    
    $sql = "INSERT INTO user VALUES (null, '$regEmail', '$password', 2)";
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
    $content = "Dear Customer!<br /><br />";
    $content .= "Thank you for choosing PPM System!<br /><br />";
    $content .= "Please confirm your account and password.<br /><br />";
    $content .= "Here is your account number and password<br />";
    $content .= "Account: $regEmail<br />";
    $content .= "Password: $password<br /><br /><br />";
    $content .= "For other technical questions and support, please contact us at 180162421@stu.vtc.edu.hk.<br /><br /><br />";
    $content .= "We look forward to working with you!<br /><br /><br />";
    $content .= "Best wishes,<br />";
    $content .= "$ourOrganization team<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";
    
    $url = '../phpmailer/send_email.php';
    // what post fields?
    $fields = array(
       'url' => '../admin/CreateRestaurant.php',
       'mailto' => $regEmail,
       'subject' => $subject,
       'body' => $content,
       'LastName' => '',
       'FirstName' => ''
    );

    // build the urlencoded data
    $postvars = http_build_query($fields);
    
    echo "<script language=\"javascript\"> window.location.href='$url?$postvars';</script>";
    
    
    //echo "<script language=\"javascript\"> setTimeout(function(){
      //  window.location = './CreateRestaurant.php';
   //}, 1000); </script>";
    //echo "<script language=\"javascript\"> window.location.href='mailto:$regEmail?subject=$subject&body=$content'; </script>";

} else {
    echo '<script language="javascript"> alert("Email already exists! Please enter a new Email!");</script>';
    echo '<script language="javascript"> window.location.href=\'./CreateRestaurant.php\';</script>';
}

mysqli_close($conn);
?>
