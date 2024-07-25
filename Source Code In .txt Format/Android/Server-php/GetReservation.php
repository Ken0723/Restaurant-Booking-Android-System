<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
		$restaurantID = $_POST["restaurantID"];
		$tableID = $_POST["tableID"];
		$date = $_POST["date"];
		$fdate = date("Y-m-d", strtotime($date));
		
		$statement = $pdo->prepare("SELECT * FROM reservation WHERE RestaurantID = ? AND TableID = ? AND ReservationDate = ?");
		$statement->bindParam(1, $restaurantID);
		$statement->bindParam(2, $tableID);
		$statement->bindParam(3, $fdate);
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