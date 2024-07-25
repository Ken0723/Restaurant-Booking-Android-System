<?php
$url = '../phpmailer/send_email.php';
    // what post fields?
    $fields = array(
       'url' => $_SERVER['PHP_SELF'],
       'mailto' => 'chanjoea2046@gmail.com',
       'subject' => '2',
       'body' => '3',
       'LastName' => '123',
       'FirstName' => '4'
    );

    // build the urlencoded data
    $postvars = http_build_query($fields);

    header("Location: $url?$postvars");
?>