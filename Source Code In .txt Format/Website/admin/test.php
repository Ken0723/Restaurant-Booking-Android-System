<?php
$to = "180162421@stu.vtc.edu.hk";//寫死的傳送對象 就是公司的信箱 不會顯示在網頁上
    $subject = "PPM System Account confirmation";
    $ourOrganization="2020 Group 3";
    $content="
Dear Customer!\n\n

Thank you for choosing PPM System!\n\n

Please confirm your account and password.\n\n

Here is your account number and password\n\n
    Account: 1\n
Password: 2\n
For other technical questions and support, please contact us at 180162421@stu.vtc.edu.hk.\n\n\n


We look forward to working with you!\n\n\n


Best wishes,\n
$ourOrganization team\n";

$content = "Dear Customer!%0A%0A";
$content .= "Thank you for choosing PPM System!%0A%0A";
$content .= "Please confirm your account and password.%0A%0A";
$content .= "Here is your account number and password%0A";
$content .= "Account: 1%0A";
$content .= "Password: 2%0A";
$content .= "For other technical questions and support, please contact us at 180162421@stu.vtc.edu.hk.%0A%0A%0A";
$content .= "We look forward to working with you!%0A%0A%0A";
$content .= "Best wishes,%0A";
$content .= "$ourOrganization team%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A%0A";
echo "<script language=\"javascript\"> setTimeout(function(){
        window.location = './CreateRestaurant.php';
   }, 1000); </script>";
echo "<script language=\"javascript\"> window.location.href='mailto:$to?subject=$subject&body=$content'; </script>";
?>