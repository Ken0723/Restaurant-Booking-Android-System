<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
		date_default_timezone_set('HongKong');
		$customerID = $_POST["customerID"];
		$status = "Starting";
		$date = date("Y-m-d") . "<br>";
		$time = date("h") . "<br>";
		
		$statement = $pdo->prepare("SELECT * FROM reservation WHERE CustomerID = ? AND Status = ?");
		$statement->bindParam(1, $customerID);
		$statement->bindParam(2, $status);
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		
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