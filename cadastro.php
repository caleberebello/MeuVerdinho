<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="header">
        <div class="container">
            <img class="logo" src="Ativo 5x1 1.png">
            <div class="divisor"></div>
            <p>Meu verdinho</p>
        </div>
    </div>
    <h1 class="controle">Controle seus gastos hoje, para colher amanhã.</h1>
    <img class="mao" src="mãos.png">

    <?php
        include('cadastro-form.php');
        include('API.php');
    ?>
    <h2>Cadastro</h2>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

    Username: <input type="text" name="username" value="<?php echo $username;?>">
    <span class="error">* <?php echo $usernameErr;?></span>
    <br><br>

    Name: <input type="text" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $nameErr;?></span>
    <br><br>

    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>

    Data de nascimento: <input type="text" name="dataNascimento" value="<?php echo $birth;?>">
    <span class="error">* <?php echo $birthErr;?></span>
    <br><br>

    Senha: <input type="text" name="senha" value="<?php echo $password;?>">
    <span class="error">* <?php echo $passwordErr;?></span>
    <br><br>

    <input type="submit" name="submit" value="Cadastrar">  
    </form>
    <?php
    $data = [
        "username" => $username,
        "login" => $email,
        "password" => $password,
        "nome" => $name,
        "data_nascimento" => $birth,
        "telefone" => null,
        "img_path" => null
    ];
    $apiCall = callAPI("POST", "http:/localhost:8000/user", json_encode($data));
    $response = json_decode($apiCall, true);
    // $errors = $response["response"]["errors"];
    $data = $response;
    echo $data;
    ?>
</body>
</html>