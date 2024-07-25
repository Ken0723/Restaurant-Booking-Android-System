<?php
	require_once 'Database_Config.php';

	if ($pdo) {
		$reservationID = $_POST['ReservationId'];
		$status = $_POST['Status'];
		$comments = $_POST['Comments'];
		$food = $_POST['FoodArray'];
		$qty = $_POST['Qty'];
		$decodeFood = json_decode($food);
		$decodeQty = json_decode($qty);
		
		$statement = $pdo->prepare("INSERT INTO order_id (ReservationID, Status, Comments) VALUES (?, ?, ?)");
		$statement->bindParam(1, $reservationID);
		$statement->bindParam(2, $status);
		$statement->bindParam(3, $comments);
		$statement->execute();
		
		$id = $pdo->lastInsertId();
		if ($statement) {
    		for($i = 0; $i < count($decodeFood); $i++) {
        		$statement = $pdo->prepare("INSERT INTO order_product (OrderID, FoodItemCode, Qty) VALUES (?, ?, ?)");
        		$statement->bindParam(1, $id);
        		$statement->bindParam(2, $decodeFood[$i]);
        		$statement->bindParam(3, $decodeQty[$i]);
        		$statement->execute();
    		}
    		if ($statement) {
    		    echo "true";
    		} else {
    		    echo null;
    		}
		} else {
		    echo null;
		}
		$pdo = null;
		
	} else {
		echo "Database connect failed!";
	}

?>