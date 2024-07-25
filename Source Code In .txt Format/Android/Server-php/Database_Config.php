<?php
	$host = 'maria_db';
	$user = 'root';
	$pass = 'docker';
	$db = 'fyp';
		
	$dsn = "mysql:host=$host;dbname=$db"; 
	try {
	    $pdo = new PDO($dsn, $user, $pass);
	} catch (\PDOException $e) {
	    throw new \PDOException($e->getMessage(), (int) $e->getCode());
	}
?>