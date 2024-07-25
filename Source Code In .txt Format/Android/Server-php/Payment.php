<?php
	require_once 'Database_Config.php';

	if ($pdo) {
	    $status = 'FinishedPayment';
        $reservationId = $_POST['reservationId'];
        $cardNum = $_POST['cardNum'];
        $securityCode = $_POST['securityCode'];
        $date = $_POST['date'];
		
		$statement = $pdo->prepare("UPDATE reservation SET Status = ? WHERE ReservationID = ?");
		$statement->bindParam(1, $status);
		$statement->bindParam(2, $reservationId);
        
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