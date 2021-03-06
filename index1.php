<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="index.css" rel="stylesheet">
    <title>Início</title>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>
</head>
<body>
    <?php
        include('API.php');
    ?>
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <button class="novo">+ Novo</button>
        <a href="#">Resumo</a>
        <a href="#">Pagamentos</a>
        <a href="#">Transações</a>
        <a href="#">Metas</a>
        <a href="#">Configurações</a>
      </div>
      
      <div id="main">
        <div class="header">
            <button class="openbtn" onclick="openNav()">&#9776;</button>
            <button class="redondo">Este mês</button>
            <button class="redondo">Este ano</button>
            <button class="redondo">Desde o início</button>
        </div>
        <div>
            <p>Resumo</p>
        </div>
        <div>
            <div class="box">
                <div class="saldo-box">
                    <?php
                        $returnData = callAPI("GET", "http://localhost:8000/wallet/?idWallet=1", false);
                        $response = json_decode($returnData, true);
                        // $errors = $response[‘response’][‘errors’];
                        $data = $response["saldo"];
                        echo $data;
                    ?>
                </div>

                <h1 class="saldo">Saldo Atual</h1>
            </div>
            <div class="box">
                <button class="circulo1" onclick="window.location.href='#abrirModal1'">
                    +
                </button>
                <h1 class="receitas">Receitas</h1>
            </div>
            <div class="box">
                <button class="circulo2" onclick="window.location.href='#abrirModal2'">
                    -
                </button>
                <h1 class="despesas">Despesas</h1>
            </div>
        </div>

        <div id="abrirModal1" class="modal">
            <a href="#fechar" title="Fechar" class="fechar">x</a>
            <h1>Nova Receita</h1>

            <?php
                include('receita-form.php');
            ?>
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
            $apiCall = callAPI("POST", "http:/localhost:8000/transaction", json_encode($data));
            $response = json_decode($apiCall, true);
            // $errors = $response["response"]["errors"];
            $data = $response;
            echo $data;
            ?>

        </div>

        <div id="abrirModal2" class="modal">
            <a href="#fechar" title="Fechar" class="fechar">x</a>
            <h1>Nova Despesa</h1>

            <?php
                include('receita-form.php');
            ?>
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
            $apiCall = callAPI("POST", "http:/localhost:8000/transaction", json_encode($data));
            $response = json_decode($apiCall, true);
            // $errors = $response["response"]["errors"];
            $data = $response;
            echo $data;
            ?>
        </div>

        <div>
            <p>Relatórios</p>
            <div class="box1">
                <div class="btn-group">
                    <button>Apple</button>
                    <button>Samsung</button>
                    <button>Sony</button>
                </div>
            </div>
        </div>
      </div>
    
</body>
</html>