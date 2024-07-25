
<?php
$hostname = "maria_db";
$username = "root";
$pwd = "docker";
$db = "test";
$conn = mysqli_connect($hostname, $username, $pwd, $db) or die(mysqli_connect_error());
?>
