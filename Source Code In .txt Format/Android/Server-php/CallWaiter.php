<?php
	require_once 'Database_Config.php';

	if ($pdo) {
	    $status = 'Calling';
		$tableId = $_POST['tableId'];
		
		$statement = $pdo->prepare("UPDATE restauranttable SET Status = ? WHERE ID = ?");
		$statement->bindParam(1, $status);
		$statement->bindParam(2, $tableId);
        
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