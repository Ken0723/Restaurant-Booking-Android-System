<?php
	require_once 'Database_Config.php';

	if ($pdo) {
	    $status = 'FinishServed';
		$ID = $_POST["ID"];
		
		$statement = $pdo->prepare("UPDATE order_id SET Status = ? WHERE ID = ?");
		$statement->bindParam(1, $status);
		$statement->bindParam(2, $ID);
        
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