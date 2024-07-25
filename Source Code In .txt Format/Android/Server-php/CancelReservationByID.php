<?php
	require_once 'Database_Config.php';

	if ($pdo) {
	    $status = "Canceled";
		$reservationID = $_POST["reservationID"];
		
		$statement = $pdo->prepare("UPDATE reservation SET Status = ? WHERE reservationID = ?");
		$statement->bindParam(1, $status);
		$statement->bindParam(2, $reservationID);
        
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