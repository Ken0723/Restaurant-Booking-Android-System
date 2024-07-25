<?php
session_start();
if(isset($_SESSION['login_user'])){
	
}else{ echo '<script language="javascript"> alert("Login frist")</script>';

	 echo '<script language="javascript"> window.location.href=\'./index.php\'; </script>';
}
