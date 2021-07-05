<?php
// define variables and set to empty values
$usernameErr = $nameErr = $emailErr = $birthErr = $websiteErr = "";
$username = $name = $email = $birth = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["username"])) {
		$usernameErr = "Username is required";
	} else {
		$username = test_input($_POST["username"]);
	
		// // check if name only contains letters and whitespace
		// if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
		// 	$usernameErr = "Only letters and white space allowed";
		// }
	}

	if (empty($_POST["name"])) {
		$nameErr = "Name is required";
	} else {
		$name = test_input($_POST["name"]);

		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
			$nameErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);

		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
		}
	}

	if (empty($_POST["dataNascimento"])) {
		$birthErr = "Data de nascimento is required";
	} else {
		$birth = test_input($_POST["dataNascimento"]);

	}

	if (empty($_POST["comment"])) {
		$comment = "";
	} else {
		$comment = test_input($_POST["comment"]);
	}

}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>