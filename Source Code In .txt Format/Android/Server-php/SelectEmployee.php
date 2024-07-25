<?php
	require_once 'Database_Config.php';
	
	if ($pdo) {
		$ID = $_POST["userID"];
		
		$statement = $pdo->prepare("SELECT * FROM employee WHERE UserID = ?");
		$statement->bindParam(1, $ID);
		$statement->execute();
		$results = $statement->fetch(PDO::FETCH_ASSOC);
		
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