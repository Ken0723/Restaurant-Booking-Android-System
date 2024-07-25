<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
		date_default_timezone_set('HongKong');
		$customerID = $_POST["customerID"];
		$tableID = $_POST["tableID"];
		$status = 'FinishedPayment';
		$date = date("Y-m-d");
		$time = date("H") . ":00:00";
		
		$statement = $pdo->prepare("SELECT * FROM reservation WHERE CustomerID = ? AND TableID = ? AND Status = ? AND ReservationDate = ? AND ReservationsTime = ?");
		$statement->bindParam(1, $customerID);
		$statement->bindParam(2, $tableID);
		$statement->bindParam(3, $status);
	    $statement->bindParam(4, $date);
	    $statement->bindParam(5, $time);
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