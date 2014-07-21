<?php
	/****************************************************************************************
	 *								Script Executed When Loaded								*
	 ****************************************************************************************/

	include("../../db/dbconnect.php");

	// *** CONSTANTS ***
	define("MAXCHARS_EMAIL", 50);
	define("MAXCHARS_USERNAME", 20);
	define("MAXCHARS_FIRSTNAME", 30);
	define("MAXCHARS_LASTNAME", 30);
	$returnInfo = array(":status" => 0, ":content" => null);
	
	// Check matching emails.
	if($_POST['email1'] != $_POST['email2']){
		$returnInfo[':status'] = 1;
		$returnInfo[':content'] = "Email addresses do not match.";
		die(json_encode($returnInfo));
	}

	// Check if the passwords/emails match.
	if($_POST['password1'] != $_POST['password2']){
		$returnInfo[':status'] = 1;
		$returnInfo[':content'] = "Passwords do not match.";
		die(json_encode($returnInfo));
	}

	// Attempt to connect to the db.
	if(dbconnect() != 0){
		$returnInfo[':status'] = 1;
		$returnInfo[':content'] = "Failed to connect.";
		die(json_encode($returnInfo));
	}

	// Check if a user attached to the provided email already exists.
	if(checkExistingUser($db, $_POST['email1']) == true){
		$returnInfo[':status'] = 1;
		$returnInfo[':content'] = "Sorry, there is already an account associated with that email.";
		die(json_encode($returnInfo));
	}
	
	// Generate a salt.
	$salt = generateSalt(32);
		
	// Append the provided password to the salt and hash it.
	$hash = hash('sha256', $salt . htmlspecialchars($_POST['password1']));
	
	// Create the user.
	createUser($db, $_POST['email1'], $_POST['firstname'], $_POST['lastname'], $salt, $hash);

	// Success
	echo json_encode($returnInfo);
	
	/****************************************************************************************
	 *										Functions										*
	 ****************************************************************************************/
	
	/*
	*  checkExistingUser
	*  Returns whether or not a user exists in the DB with a provided email.
	*/
	function checkExistingUser($db, $email){

		// Prepare a query.
		$check_existing_user = $db->prepare("SELECT * FROM user WHERE Email = :email");
	
		// Parameterize the user-entered email.
		$params = array(":email" => htmlspecialchars($email));
	
		// Execute the query.
		$check_existing_user->execute($params);
	
		// See if anything was returned. Display an error if anything is.
		if($check_existing_user->fetch())
			return true;
		else
			return false;
	}
	
	/*
	*  generateSalt
	*  Randomly generates string of $length characters. (salt)
	*/
	function generateSalt($length){
		$characters = 'abcdefghijklmnopqrstuvwxyz123';	// Possible characters for the salt.
		$lastchar = strlen($characters) - 1;

		$salt = '';
		for ($i = 0; $i < $length; $i++){				// Do $length times...
			$index = mt_rand(0, $lastchar);				// Pick a random number.
			$character = $characters{$index};			// Use it to pick a random character.
			$salt .= $character;						// Append that character to the salt.
		}
		return $salt;
	}
	
	/*
	*  createUser
	*  Inserts a user into the database.
	*/
	function createUser($db, $email, $firstname, $lastname, $salt, $hash){

		// Check limits.
		if(strlen($email) > MAXCHARS_EMAIL)			die(json_encode([":status" => 1, ":content" => "Email cannot be more that ". MAXCHARS_EMAIL . " characters."]));
		if(strlen($firstname) > MAXCHARS_FIRSTNAME)	die(json_encode([":status" => 1, ":content" => "First name cannot be more that " . MAXCHARS_FIRSTNAME . " characters."]));
		if(strlen($lastname) > MAXCHARS_LASTNAME)	die(json_encode([":status" => 1, ":content" => "Last name cannot be more that " . MAXCHARS_LASTNAME . " characters."]));
		
		// Prepare the insert query.
		$insert_user_query = $db->prepare("
			INSERT INTO user VALUES (:email, :firstname, :lastname, :salt, :hash)
		");
		
		// Parameterize the user information.
		$params = array(
			":email" => htmlspecialchars($email),
			":firstname" => htmlspecialchars($firstname),
			":lastname" => htmlspecialchars($lastname),
			":salt" => htmlspecialchars($salt),
			":hash" => htmlspecialchars($hash)
		);
		
		try{
			// Execute the insertion.
			$insert_user_query->execute($params);
		} catch (PDOException $e){
			// Display an error.
			$returnInfo[':status'] = 1;
			$returnInfo[':content'] = "There was an error creating the user:\n\n" . $insert_user_query->errorInfo()[2];
			die(json_encode($returnInfo));
		}
	}
?>