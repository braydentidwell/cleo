<?php
	// Database object
	$db = null;

	// Establish a connection to the database. Will return 0 on success and 1 on failure.
	function dbconnect(){

		global $db;

		// Attempt a connection.
		try{
			// Create a new PDO object.
			$db = new PDO(
				"mysql:host=localhost;dbname=cleodev",
				"cleodev",
				"vedoelc"
			);
		} catch(Exception $e) {
			return 1;
		};

		// Have the PDO object throw an exception if anything happens.
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return 0;
	}
?>