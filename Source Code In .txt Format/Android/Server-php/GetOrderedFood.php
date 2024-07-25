<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
		
        $statement = $pdo->prepare("SELECT OrderID, FoodItemCode, Qty FROM order_product");
        $statement->execute();
        $food = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        if ($statement != null) {
            $item = json_encode($food);
            echo $item;
        } else {
            echo null;
        }

		$pdo = null;
		
	} else {
		echo "Database connect failed!";
	}
?>