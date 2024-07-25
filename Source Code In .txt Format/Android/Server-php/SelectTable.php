<?php
	require_once 'Database_Config.php';
	
	if ($pdo) {
		
		$statement = $pdo->prepare("SELECT * FROM restauranttable");
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