<?php
	require_once 'Database_Config.php';

	if ($pdo) {
	    $password = $_POST["password"];
		$customerID = $_POST["customerID"];
		
		$statement = $pdo->prepare("UPDATE user SET Password = ? WHERE ID = ?");
		$statement->bindParam(1, $password);
		$statement->bindParam(2, $customerID);
        
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