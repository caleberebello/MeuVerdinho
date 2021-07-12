<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <title>Início</title>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "280px";
            document.getElementById("main").style.marginLeft = "250px";
            document.querySelector(".openbtn").style.display = "none";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            document.querySelector(".openbtn").style.display = "initial";
        }
    </script>
</head>
<body>
    <?php
        include('API.php');
        include('receita-form.php');
    ?>
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="group-user">
            <img src="img/user.png" class="img-redonda">
            <div>
                <p class="nome">Amanda Castro</p>
                <p class="usuario">@amanda_cs</p>
            </div>
            <img src="img/logout.png" class="logout">
        </div>
        <div class="divisor"></div>
        <div class="carteira">
            <img src="img/Active.png" alt="carteira">
            <div class="txt-carteira">
                <p>Minha carteira</p>
                <p>Carteira própria</p>
            </div>
            <div class="add-green"><p>+</p></div>
            
        </div>
        <div class="divisor"></div>
        <button class="novo">+ Novo</button>
        <ul class="menu">
            <li class="active"><a href=""><img src="img/resumo.png" class="icon-menu">Resumo</a></li>
            <li><a href=""><img src="img/pagamentos.png" class="icon-menu">Pagamentos</a></li>
            <li><a href=""><img src="img/transacoes.png" class="icon-menu">Transações</a></li>
            <li><a href=""><img src="img/metas.png" class="icon-menu">Metas</a></li>
            <li><a href=""><img src="img/configuracoes.png" class="icon-menu">Configurações</a></li>
        </ul>
    </div>
      
    <div id="main">
        <div class="header">
            <button class="openbtn" onclick="openNav()">&#9776;</button>
            <div class="container">
                
                <button class="redondo btn-filtro active">Este mês</button>
                <button class="redondo btn-filtro">Este ano</button>
                <button class="redondo btn-filtro">Desde o início</button>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div>
                    <p class="title" >Resumo</p>
                </div>
                <div class="group-box">
                    <div class="box">
                        <h1 class="txt-saldo">Saldo Atual</h1>

                        <?php
                        $returnData = callAPI("GET", $url . "/wallet/?idWallet=1", false);
                        $response = json_decode($returnData, true);
                        // $errors = $response[‘response’][‘errors’];
                        $data = number_format(floatval($response["saldo"]), 2, ',', '.');
                        ?>

                        <p class="saldo">R$ <?=$data?></p>
                    </div>
                    <div class="box">
                        
                        <div class="circulo1" onclick="window.location.href='#abrirModal1'">
                            <img src="img/add.png">
                        </div>
                        <div class="txt-icon">
                            <h1 class="receitas">Receitas</h1> 
                            <p>Previsto</p>
                        </div>

                        <?php
                        $data = [
                            'carteira_id' => 1
                        ];

                        $returnData = callAPI("GET", $url . "/transaction-total", json_encode($data));
                        $response = json_decode($returnData, true);
                        // $errors = $response[‘response’][‘errors’];
                        $data = number_format(floatval($response['result']['total_receita']), 2, ',', '.');
                        ?>
                        
                        <p class="saldo-previsto">R$ <?=$data?></p>
                    </div>
    
                    <div class="box">
                        <div>
                            <div class="circulo2" onclick="window.location.href='#abrirModal2'">
                                <img src="img/add.png">
                            </div>
                        </div>
                        
    
                        <div class="txt-icon">
                            <h1 class="despesas">Despesas</h1>
                            <p>Previsto</p>
                        </div>
    
                        <div>
                            <?php
                            $data = [
                                'carteira_id' => 1
                            ];

                            $returnData = callAPI("GET", $url . "/transaction-total", json_encode($data));
                            $response = json_decode($returnData, true);
                            // $errors = $response[‘response’][‘errors’];
                            $data = number_format(floatval($response['result']['total_despesa']), 2, ',', '.');
                            ?>
                            <p class="saldo-previsto">R$ <?=$data?></p>
                        </div>
                        
                    </div>
                </div>

                <div>
                    <p class="title">Metas</p>
                </div>

                <div class="group-box">
                    <div class="box">
                        <?php
                            $data = [
                                'carteira_id' => 1
                            ];

                            $returnData = callAPI("GET", $url . "/goal-wallet", json_encode($data));
                            $response = json_decode($returnData, true);
                            // $errors = $response[‘response’][‘errors’];
                            $data = $response['result'][0];
                        ?>
                        <h1 class="txt-saldo"><?=$data['descricao']?></h1>
                        <p class="saldo">R$ <?=number_format(floatval($data['valor']), 2, ',', '.')?></p>
                    </div>
                    <div class="box gray">
                        <img src="img/add2.png">
                    </div>
                </div>
    
                <div>
                    <p class="title">Relatórios</p>
                    <div class="box1">
                        <div class="btn-group">
                            <div class="active"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.2104 14.8901C19.5742 16.3946 18.5792 17.7203 17.3123 18.7514C16.0454 19.7825 14.5452 20.4875 12.9428 20.8049C11.3405 21.1222 9.68483 21.0422 8.12055 20.5719C6.55627 20.1015 5.13103 19.2551 3.96942 18.1067C2.80782 16.9583 1.94522 15.5428 1.45704 13.984C0.968859 12.4252 0.869965 10.7706 1.169 9.16471C1.46804 7.55886 2.1559 6.05071 3.17245 4.77211C4.189 3.49351 5.50329 2.4834 7.0004 1.83008" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 11C21 9.68678 20.7413 8.38642 20.2388 7.17317C19.7362 5.95991 18.9997 4.85752 18.0711 3.92893C17.1425 3.00035 16.0401 2.26375 14.8268 1.7612C13.6136 1.25866 12.3132 1 11 1V11H21Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg></div>
                            <div><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 12H18L15 21L9 3L6 12H2" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg></div>
                            <div><svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 17V7" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13 17V1" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M1 17V13" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg></div>
                        </div>
                    </div>

                    <div class="box2">
                        <div class="img-relatorio">
                            <img src="img/bro.png">
                        </div>
                        <div class="traco"></div>
                        <div>
                            <p>Sem dados <br> para <br>analisar</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        

        <div id="abrirModal1" class="modal">
            <a href="#fechar" title="Fechar" class="fechar">x</a>
            <h1>Nova Receita</h1>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

            Valor: <input type="text" name="valor" value="<?php echo $value;?>">
            <span class="error">* <?php echo $valueErr;?></span>
            <br><br>

            Descricao: <input type="text" name="descricao" value="<?php echo $description;?>">
            <span class="error">* <?php echo $descriptionErr;?></span>
            <br><br>

            Data de vencimento: <input type="text" name="data_vencimento" value="<?php echo $expire;?>">
            <span class="error">* <?php echo $expireErr;?></span>
            <br><br>

            Recorrencia: <input type="text" name="recorrencia" value="<?php echo $recurrence;?>">
            <span class="error">* <?php echo $recurrenceErr;?></span>
            <br><br>

            Categoria: <input type="text" name="categoria" value="<?php echo $category;?>">
            <span class="error">* <?php echo $categoryErr;?></span>
            <br><br>

            Conta: <input type="text" name="carteira" value="<?php echo $wallet;?>">
            <span class="error">* <?php echo $walletErr;?></span>
            <br><br>

            Situacao: <input type="text" name="situacao" value="<?php echo $situation;?>">
            <span class="error">* <?php echo $situationErr;?></span>
            <br><br>

            <input type="submit" name="submit" value="Salvar">  
            </form>
            <?php
            $data = [
                "valor" => floatval($value),
                "descricao" => $description,
                "data_vencimento" => $expire,
                "recorrencia" => $recurrence,
                "categoria" => intval($category),
                "carteira_id" => intval($wallet),
                "situacao" => $situation,
                "tipo_registro" => "R"
            ];
            $apiCall = callAPI("POST", $url . "/transaction", json_encode($data));
            $response = json_decode($apiCall, true);
            // $errors = $response["response"]["errors"];
            $data = $response;
            ?>
        </div>

        <div id="abrirModal2" class="modal">
            <a href="#fechar" title="Fechar" class="fechar">x</a>
            <h1>Nova Despesa</h1>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

            Valor: <input type="text" name="valor" value="<?php echo $value;?>">
            <span class="error">* <?php echo $valueErr;?></span>
            <br><br>

            Descricao: <input type="text" name="descricao" value="<?php echo $description;?>">
            <span class="error">* <?php echo $descriptionErr;?></span>
            <br><br>

            Data de vencimento: <input type="text" name="data_vencimento" value="<?php echo $expire;?>">
            <span class="error">* <?php echo $expireErr;?></span>
            <br><br>

            Recorrencia: <input type="text" name="recorrencia" value="<?php echo $recurrence;?>">
            <span class="error">* <?php echo $recurrenceErr;?></span>
            <br><br>

            Categoria: <input type="text" name="categoria" value="<?php echo $category;?>">
            <span class="error">* <?php echo $categoryErr;?></span>
            <br><br>

            Conta: <input type="text" name="carteira" value="<?php echo $wallet;?>">
            <span class="error">* <?php echo $walletErr;?></span>
            <br><br>

            Situacao: <input type="text" name="situacao" value="<?php echo $situation;?>">
            <span class="error">* <?php echo $situationErr;?></span>
            <br><br>

            <input type="submit" name="submit" value="Salvar">  
            </form>
            <?php
            $data = [
                "valor" => floatval($value),
                "descricao" => $description,
                "data_vencimento" => $expire,
                "recorrencia" => $recurrence,
                "categoria" => intval($category),
                "carteira_id" => intval($wallet),
                "situacao" => $situation,
                "tipo_registro" => "D"
            ];
            $apiCall = callAPI("POST", $url . "/transaction", json_encode($data));
            $response = json_decode($apiCall, true);
            // $errors = $response["response"]["errors"];
            $data = $response;
            ?>
        </div>

        
    </div>
    
</body>
</html>