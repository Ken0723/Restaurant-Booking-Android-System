<?php
	require_once 'Database_Config.php';

	if ($pdo) {
		$customerID = $_POST["customerID"];
		$lastName = $_POST["lastName"];
		$firstName = $_POST["firstName"];
		$phone = $_POST["phone"];
		$address = $_POST["address"];
		
		$statement = $pdo->prepare("UPDATE customer SET LastName = ?, FirstName = ?, Phone = ?, Address = ? WHERE UserID = ?");
		$statement->bindParam(1, $lastName);
		$statement->bindParam(2, $firstName);
		$statement->bindParam(3, $phone);
		$statement->bindParam(4, $address);
		$statement->bindParam(5, $customerID);
        
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