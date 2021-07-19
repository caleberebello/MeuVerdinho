<?php
// define variables and set to empty values
$usernameErr = $nameErr = $emailErr = $birthErr = $passwordErr = "";
$username = $name = $lastName = $email = $birth =  $password = "";

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

	if (empty($_POST["nome"])) {
		$nameErr = "Name is required";
	} else {
		$name = test_input($_POST["nome"]);

		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
			$nameErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["sobrenome"])) {
		$nameErr = "Name is required";
	} else {
		$lastNname = test_input($_POST["sobrenome"]);

		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$lastName)) {
			$nameErr = "Only letters and white space allowed";
		}
	}
	
	
	if (empty($_POST["dataNascimento"])) {
		$birthErr = "Data de nascimento is required";
	} else {
		$birth = test_input($_POST["dataNascimento"]);
		
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

	if (empty($_POST["senha"])) {
		$passwordErr = "Senha is required";
	} else {
		$password = test_input($_POST["senha"]);

		// // check if name only contains letters and whitespace
		// if (!preg_match("/^[a-zA-Z-' ]*$/",$password)) {
		// 	$passwordErr = "Only letters and white space allowed";
		// }
	}

}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>