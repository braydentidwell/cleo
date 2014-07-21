<?php
	/****************************************************************************************
	 *								Script Executed When Loaded								*
	 ****************************************************************************************/

	session_name("cleo_usr");
	session_set_cookie_params(0);
	session_start();
	 
	$returnInfo = array(":status" => 0, ":content" => null);
	 
	// Check if a user is already logged in.
	if(isset($_SESSION['cleo_usr'])){
		$returnInfo[":status"] = 1;
		$returnInfo[":content"] = "You are already logged in as " . $_SESSION['cleo_usr'];
		die(json_encode($returnInfo));
	}
	 
	// Connect to the DB.
	include("../../db/dbconnect.php");

	// Attempt to connect to the db.
	if(dbconnect() != 0){
		$returnInfo[':status'] = 1;
		$returnInfo[':content'] = "Failed to connect.";
		die(json_encode($returnInfo));
	}

	// Attempt to log the user in.
	$returnInfo[":content"] = attemptLogin($db, $_POST['email'], $_POST['password']);
	
	// Start the loggedin PHP session.
	$_SESSION['cleo_usr'] = $_POST['email'];

	echo(json_encode($returnInfo));
	
	/****************************************************************************************
	 *										Functions										*
	 ****************************************************************************************/
	
	/*
	*  attemptLogin
	*  Returns whether or not a user exists in the DB with a provided email.
	*/
	function attemptLogin($db, $email, $password){

		// Prepare a query.
		$salt_query = $db->prepare("SELECT salt FROM user WHERE Email = :email");
		$params = array(":email" => htmlspecialchars($email));
		$salt_query->execute($params);
	
		// See if anything was returned. Display an error if anything is.
		if($salt = $salt_query->fetch()){
		
			// Generate a hash to compare to what's in the database.
			$hash = hash('sha256', $salt[0] . htmlspecialchars($_POST['password']));
			
			// Compare the generated hash to the one in the database.
			$login_query = $db->prepare("
				SELECT Firstname, Lastname FROM user
				WHERE
					Email = :email
				AND
					hash = :hash
			");
			
			$params = array(":email" => htmlspecialchars($email),
							":hash" => $hash);
			
			// Retrieve and return the user information if the credentials were valid.
			$login_query->execute($params);
			if($login_data = $login_query->fetch()){

				$firstname = $login_data['Firstname'];
				$lastname = $login_data['Lastname'];

				return [":firstname" => $firstname,
						":lastname" => $lastname];
			}
			// Incorrect password.
			else{
				$returnInfo[":status"] = 1;
				$returnInfo[":content"] = "Email/password combination is invalid.";
				die(json_encode($returnInfo));
			}
		}
		// User doesn't exist.
		else{
			$returnInfo[":status"] = 1;
			$returnInfo[":content"] = "There is no user associated with that email.";
			die(json_encode($returnInfo));
		}
	}
?>