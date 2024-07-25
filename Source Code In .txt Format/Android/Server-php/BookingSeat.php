<?php
	require_once 'Database_Config.php';

	if ($pdo) {
		date_default_timezone_set('HongKong');
		$restaurantID = $_POST["restaurantID"];
		$customerID = $_POST["customerID"];
		$tableID = $_POST["tableID"];
		$date = $_POST["date"];
		$time = $_POST["time"];
		$status = "Booked";
		$fdate = date("Y-m-d", strtotime($date));
		
		$statement = $pdo->prepare("INSERT INTO reservation (RestaurantID, CustomerID, TableID, ReservationDate, ReservationsTime, Status)
		                            VALUES (?, ?, ?, ?, ?, ?)");
		$statement->bindParam(1, $restaurantID);
		$statement->bindParam(2, $customerID);
		$statement->bindParam(3, $tableID);
		$statement->bindParam(4, $fdate);
		$statement->bindParam(5, $time);
		$statement->bindParam(6, $status);
		$statement->execute();
		
		$d = strtotime("+3 Days");
		$paymentDate = date("Y-m-d", $d);
		$amount = 100;
		$paymentType = 'Credit card';
		$id = $pdo->lastInsertId();
		$statement = $pdo->prepare("INSERT INTO payment (ReservationID, CustomerID, PaymentDate, Amount, PaymentType)
		                            VALUES (?, ?, ?, ?, ?)");
		$statement->bindParam(1, $id);
		$statement->bindParam(2, $customerID);
		$statement->bindParam(3, $paymentDate);
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