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
    <?php
        include('cadastro-form.php');
        include('API.php');

        function registerUser($data){
            $apiCall = callAPI("POST", $GLOBALS['url'] . "/user", json_encode($data));
            $response = json_decode($apiCall, true);
            // $errors = $response["response"]["errors"];
            return $response;
        }

        if (isset($_POST['submit'])){
            $data = [
                "username" => $username,
                "login" => $email,
                "password" => $password,
                "nome" => $name . " ". $lastName,
                "data_nascimento" => $birth,
                "telefone" => null,
                "img_path" => null
            ];
            registerUser($data);

            // if($response['http_code'] == 200){
            //     $action = "dashboard.php";
            // }else{
            //     $action = "cadastro.php";
            // }
        }
    ?>
    <header>
        <img src="img/logo-header.png" alt="" style="height: 100px;">
        <div class="divisor">
        </div>
        <h1 class="meuverdinho">Meu<br> Verdinho</h1>
    </header>
    <main>
        <div class="content">
            <div class="detalhe-body">
                <svg width="336" height="268" viewBox="0 0 336 268" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="336" height="268">
                    <rect width="336" height="268" fill="#C4C4C4"/>
                    </mask>
                    <g mask="url(#mask0)">
                    <circle cx="160.203" cy="-16.3805" r="176" transform="rotate(-59.8223 160.203 -16.3805)" fill="#683A25"/>
                    <circle cx="-4" cy="91" r="176" fill="#CEAA9A"/>
                    <circle cx="-10.8152" cy="-51.8148" r="204.648" transform="rotate(24.5547 -10.8152 -51.8148)" fill="url(#paint0_linear)"/>
                    </g>
                    <defs>
                    <linearGradient id="paint0_linear" x1="197.783" y1="-49.5575" x2="-304.764" y2="-83.7326" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#42A831"/>
                    <stop offset="0.687545" stop-color="#285521"/>
                    </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="chamada">
                <h1 class="controle">Controle seus gastos hoje,<br> para colher amanhã.</h1>
                <img class="mao" src="mãos.png">
            </div>

            <div class="formulario">
                <div class="links">
                    <ul>
                        <li><a href="#">ENTRAR</a></li>
                        <li><a href="#">CADASTRAR</a></li>
                    </ul>
                </div>

                <form method="post" action="dashboard.php">
                    <div class="group-input">
                        <label for="username">Nome de Usuário</label>
                        <div class="input">
                            <input id="username" type="text" placeholder="amanda_cs" name="username" value="<?php echo $username;?>">
                        </div>
                        
                    </div>

                    <div class="group-input">
                        <label for="name">Nome</label>
                        <input id="name" type="text" placeholder="Amanda" name="nome" value="<?php echo $name;?>">
                    </div>

                    <div class="group-input">
                        <label for="secondName">Sobrenome</label>
                        <input id="secondName" type="text" placeholder="Castro Silva" name="sobrenome" value="<?php echo $lastName;?>">
                    </div>

                    <div class="group-input">
                        <label for="birthday">Data de Nascimento</label>
                        <input id="birthday" type="text" placeholder="1992-02-29" name="dataNascimento" value="<?php echo $birth;?>">
                    </div>

                    <div class="group-input">
                        <label for="email">E-mail</label>
                        <input id="email" type="text" placeholder="exemplo@gmail.com" name="email" value="<?php echo $email;?>">
                    </div>

                    <div class="group-input">
                        <label for="password">Senha</label>
                        <input id="password" type="password" placeholder="********" name="senha" value="<?php echo $password;?>">
                    </div>

                    <div class="cadastrar">
                        <!-- <a href="dashboard.php"> -->
                        <input type="submit" name="submit" value="CADASTRAR">  
                    </div>
                </form>
                <?php
                
                
                ?>
            </div>
        </div>
        
    </main>
</body>
</html>