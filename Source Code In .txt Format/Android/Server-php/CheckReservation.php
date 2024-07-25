<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
		date_default_timezone_set('HongKong');
		$restaurantID = $_POST["restaurantID"];
		$tableID = $_POST["tableID"];
		$date = $_POST["date"];
		$time = $_POST["time"];
		$fdate = date("Y-m-d", strtotime($date));
		
		$statement = $pdo->prepare("SELECT * FROM reservation WHERE RestaurantID = ? AND TableID = ? AND ReservationDate = ? AND ReservationsTime = ?");
		$statement->bindParam(1, $restaurantID);
		$statement->bindParam(2, $tableID);
		$statement->bindParam(3, $fdate);
		$statement->bindParam(4, $time);
		$statement->execute();
		
		$results = $statement->fetch(PDO::FETCH_ASSOC);
		
		if ($results == null) {
			echo "true";
		} else {
			echo null;
		}

		$pdo = null;
		
	} else {
		echo "Database connect failed!";
	}
?>