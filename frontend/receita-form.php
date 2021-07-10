<?php
// define variables and set to empty values
$valueErr = $descriptionErr = $expireErr = $recurrenceErr = $categoryErr = $walletErr = $situationErr = "";
$value = $description = $expire = $recurrence =  $category =  $wallet = $situation = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["valor"])) {
		$valueErr = "Value is required";
	} else {
		$value = test_input($_POST["valor"]);
	
		// // check if description only contains numbers
		// if (!preg_match("/^[a-zA-Z-' ]*$/",$description)) {
		// 	$valueErr = "Only letters and white space allowed";
		// }
	}

	if (empty($_POST["descricao"])) {
		$descriptionErr = "Description is required";
	} else {
		$description = test_input($_POST["descricao"]);

		// // check if description only contains letters and whitespace
		// if (!preg_match("/^[a-zA-Z-' ]*$/",$description)) {
		// 	$descriptionErr = "Only letters and white space allowed";
		// }
	}
	
    if (empty($_POST["data_vencimento"])) {
        $expireErr = "expire is required";
    } else {
        $expire = test_input($_POST["data_vencimento"]);

        // // check if e-mail address is well-formed
        // if (!filter_var($expire, FILTER_VALIDATE_EMAIL)) {
        // 	$expireErr = "Invalid expire format";
        // }
    }

	if (empty($_POST["recorrencia"])) {
		$recurrenceErr = "recorrencia is required";
	} else {
		$recurrence = test_input($_POST["recorrencia"]);
		
	}

	if (empty($_POST["categoria"])) {
		$categoryErr = "categoria is required";
	} else {
		$category = test_input($_POST["categoria"]);

	}

    if (empty($_POST["carteira"])) {
		$walletErr = "carteira is required";
	} else {
		$wallet = test_input($_POST["carteira"]);

	}

    if (empty($_POST["situacao"])) {
		$situationErr = "situacao is required";
	} else {
		$situation = test_input($_POST["situacao"]);

	}

}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>