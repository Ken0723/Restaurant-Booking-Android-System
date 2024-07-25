<?php
	require_once 'Database_Config.php';

	if ($pdo) {
	    $status = $_POST['Status'];
        $id = $_POST['ID'];
		
		$statement = $pdo->prepare("UPDATE restauranttable SET Status = ? WHERE ID = ?");
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