<!DOCTYPE html>
<html>
    <head>
        <title> </title>
    </head>
    <body>
<?php

	require_once 'Database_Config.php';
	
	if ($pdo) {
		
		$statement = $pdo->prepare("SELECT * FROM fooditem");
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
    </body>
</html>