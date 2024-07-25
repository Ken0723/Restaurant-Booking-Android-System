<?php
	require_once 'Database_Config.php';

	if ($pdo) {
        $reservationId = $_POST['reservationId'];
        $nStatus = 'Starting';
        $oStatus = 'FinishedPayment';
		
		$statement = $pdo->prepare("UPDATE reservation SET Status = ? WHERE ReservationID = ? AND Status = ?");
		$statement->bindParam(1, $nStatus);
		$statement->bindParam(2, $reservationId);
		$statement->bindParam(3, $oStatus);
        
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