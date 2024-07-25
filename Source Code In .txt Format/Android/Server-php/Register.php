<?php
	require_once 'Database_Config.php';

	if ($pdo) {
		$firstName = $_POST["firstName"];
		$lastName = $_POST["lastName"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$phone = $_POST["phone"];
		$address = $_POST["address"];
		$groupID = 0;
		
		$statement = $pdo->prepare("INSERT INTO user (Email, Password, GroupID) VALUES (?, ?, ?)");
		$statement->bindParam(1, $email);
		$statement->bindParam(2, $password);
		$statement->bindParam(3, $groupID);
		$statement->execute();
		
		$id = $pdo->lastInsertId();
		$statement = $pdo->prepare("INSERT INTO customer (UserID, LastName, FirstName, Phone, Address) VALUES (?, ?, ?, ?, ?)");
		$statement->bindParam(1, $id);
		$statement->bindParam(2, $lastName);
		$statement->bindParam(3, $firstName);
		$statement->bindParam(4, $phone);
		$statement->bindParam(5, $address);
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