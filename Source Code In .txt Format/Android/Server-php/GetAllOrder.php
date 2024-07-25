<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
        $reservationID = $_POST['reservationId'];
		
		$statement = $pdo->prepare("SELECT * FROM order_id WHERE ReservationID  = ?");
		$statement->bindParam(1, $reservationID);
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		if ($results != null) {
			$order = json_encode($results);
			echo $order;
		} else {
			echo null;
		}
		$pdo = null;
		
	} else {
		echo "Database connect failed!";
	}
?>