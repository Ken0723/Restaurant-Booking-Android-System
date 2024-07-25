<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
		$status = "Starting";
		
		$statement = $pdo->prepare("SELECT * FROM reservation WHERE Status = ?");
		$statement->bindParam(1, $status);
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