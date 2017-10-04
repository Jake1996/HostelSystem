<?php

	//all use functions
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function redirect_to($location)
	{
		header("Location: ".$location);
		exit;
	}

	function mysql_prep($string)
	{
		global $connection;
		$safe = mysqli_real_escape_string($connection,$string);
		return $safe;
	}

	//functions for handling admin users
	function find_admin_by_usn($usn) {
		global $connection;

		$safe_usn = mysqli_real_escape_string($connection, $usn);
		$query  = "SELECT * ";
		$query .= "FROM Student ";
		$query .= "WHERE usn = '{$safe_usn}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);

		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}
	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}

	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));

		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);

		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);

		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);

		return $salt;
	}

	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}

	function attempt_login($usn, $password) {

		$admin = find_admin_by_usn($usn);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["paswd"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}

	function logged_in() {
		return isset($_SESSION['admin_id']);
	}

	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}

?>
