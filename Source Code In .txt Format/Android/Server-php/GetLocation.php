<?php
	require_once 'Database_Config.php';
	
	if ($pdo) {
		
		$statement = $pdo->prepare("SELECT * FROM restaurant");
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