<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
		$email = $_POST["email"];
		$password = $_POST["password"];
		
		$statement = $pdo->prepare("SELECT * FROM user WHERE Email = ? AND Password = ?");
		$statement->bindParam(1, $email);
		$statement->bindParam(2, $password);
		$statement->execute();
		$results = $statement->fetch(PDO::FETCH_ASSOC);

		if ($results != null) {
			$json = json_encode($results);
		} else {
			$json = null;
		}
		
		echo $json;
		
		$pdo = null;
	} else {
		echo "Database connect failed!";
	}
?>