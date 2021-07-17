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
    <link href="historico_despesa.css" rel="stylesheet">
    <title>Histórico de Despesas</title>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "280px";
            document.getElementById("main").style.marginLeft = "250px";
            document.querySelector(".box-grande").style.marginLeft = "458px";
            document.querySelector(".openbtn").style.display = "none";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            document.querySelector(".box-grande").style.marginLeft = "598px";
            document.querySelector(".openbtn").style.display = "initial";
        }
    </script>
</head>
<body>
    <?php
        include('API.php');
    ?>
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="group-user">
            <img src="img/user.png" class="img-redonda">
            <div>
                <?php
                    $returnData = callAPI("GET", $url . "/user", false);
                    $response = json_decode($returnData, true);
                    $data = $response['result'][1];
                ?>
                <p class="nome"><?=$data['nome']?></p>
                <p class="usuario"><?=$data['username']?></p>
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
                <p style="margin-top: 65px; margin-right: 130px; margin-left: 95px;">Relatório</p>
                <div class="group-box">
                    <div class="box">
                        <h1 class="txt-saldo">Despesas Pendentes</h1>
                        <?php
                            $data = [
                                'carteira_id' => 1
                            ];

                            $returnData = callAPI("GET", $url . "/transaction-total", json_encode($data));
                            $response = json_decode($returnData, true);
                            // $errors = $response[‘response’][‘errors’];
                            $data = number_format(floatval($response['result']['total_receita']), 2, ',', '.');
                        ?>
                        <p class="saldo">R$ <?=$data?></p>
                    </div>
                    <div class="box">
                        <h1 class="txt-saldo1">Despesas Pagas</h1>
                        <p class="saldo1">R$ <?=$data?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-grande">
            <?php
                $data = [
                    'carteira_id' => 1,
                    'tipo_registro' => 'R'
                ];

                $revenueArray = [];

                $returnData = callAPI("GET", $url . "/transaction-type", json_encode($data));
                $response = json_decode($returnData, true);
                // $errors = $response[‘response’][‘errors’];
                $data = $response['result'];
                foreach($data as $revenue){
                    array_push($revenueArray, $revenue);
                }
            ?>
            <div class="texto">
                <p style="font-size: 16px; font-style: normal; margin: 50px;">Situação</p>
                <p style="font-size: 16px; font-style: normal; margin: 50px;">Data</p>
                <p style="font-size: 16px; font-style: normal; margin: 50px;">Descrição</p>
                <p style="font-size: 16px; font-style: normal; margin: 50px;">Categoria</p>
                <p style="font-size: 16px; font-style: normal; margin: 50px;">Conta</p>
                <p style="font-size: 16px; font-style: normal; margin: 50px;">Valor</p>
                <p style="font-size: 16px; font-style: normal; margin: 50px;">Ação</p>
            </div>
            <div class="divisor"></div>
            <div class="itens">
                <table rules=none>
                    <?php foreach($data as $revenue): ?>
                        <tr>
                            <td><?= $revenue['situacao']; ?></td>
                            <td><?= $revenue['data_vencimento']; ?></td>
                            <td><?= $revenue['descricao']; ?></td>
                            <td><?= $revenue['categoria']; ?></td>
                            <td><?= $revenue['carteira_id']; ?></td>
                            <td><?= $revenue['valor']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="divisor"></div>
            <div class="oloco">
                <button class="button">BAIXAR</button>
            </div>
        </div>
    
</body>
</html>