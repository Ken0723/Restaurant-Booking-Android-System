<?php
	require_once 'Database_Config.php';

	if ($pdo) {
	    $status = 'Finished';
	    $id = $_POST['reservationId'];
		
		$statement = $pdo->prepare("UPDATE reservation SET Status = ? WHERE ReservationID = ?");
		$statement->bindParam(1, $status);
		$statement->bindParam(2, $id);
        
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