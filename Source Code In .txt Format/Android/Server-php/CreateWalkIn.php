<?php
	require_once 'Database_Config.php';

	if ($pdo) {
	    date_default_timezone_set('HongKong');
		$account = $_POST['account'];
		$tableID = $_POST['tableId'];
		$time = $_POST['time'];
		$restaurantID = $_POST['restaurantId'];
		$date = date("Y-m-d");
		$ftime = date("H", strtotime($time)) . ":00:00";
		$status = "FinishedPayment";
		$amount = '100';
		$paymentType = 'Walk-in';
		
		$statement = $pdo->prepare("INSERT INTO reservation (RestaurantID, CustomerID , TableID, ReservationDate, ReservationsTime, Status) VALUES (?, ?, ?, ?, ?, ?)");
		$statement->bindParam(1, $restaurantID);
		$statement->bindParam(2, $account);
		$statement->bindParam(3, $tableID);
		$statement->bindParam(4, $date);
		$statement->bindParam(5, $ftime);
		$statement->bindParam(6, $status);
		$statement->execute();
		
		$id = $pdo->lastInsertId();
		$statement = $pdo->prepare("INSERT INTO payment (ReservationID, CustomerID, PaymentDate, Amount, PaymentType) VALUES (?, ?, ?, ?, ?)");
		$statement->bindParam(1, $id);
		$statement->bindParam(2, $account);
		$statement->bindParam(3, $date);
		$statement->bindParam(4, $amount);
		$statement->bindParam(5, $paymentType);
		$statement->execute();
		if ($statement) {
			echo "true";
		} else {
			echo null;
		}
		
		$pdo = null;
		
	} else {
		echo "Database connect failed!";
	}

?>