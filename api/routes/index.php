<?php

use function src\slimConfiguration;

use App\Controllers\PostgreSQL\AttendanceController;
use App\Controllers\PostgreSQL\UserController;
use App\Controllers\PostgreSQL\TransactionController;
use App\Controllers\PostgreSQL\WalletController;
use App\Controllers\PostgreSQL\GoalController;
use Tuupola\Middleware\JwtAuthentication;

$app = new \Slim\App(slimConfiguration());

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Credentials', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Token, X-Requested-With, Content-Type, Accept, Origin, Authorization, X-Real-IP, Forwarded,X-Forwarded-For,X-Forwarded,X-Cluster-Client-Ip,Client-Ip')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/mygreen-version', function ($request, $response, $args) {
    return $response
    ->withStatus(200)
    ->withjson([
        'descricao' => 'Goblin\'s Cash - TESTE',
        'versao-api' => '01.000.00'
    ]);
});

$app->post('/login', AuthenticateController::class . ':login');

$app->post('/user', UserController::class . ':registerUser');
$app->get('/user', UserController::class . ':listUsers');

$app->post('/wallet', WalletController::class . ':registerWallet');
$app->post('/share-wallet', WalletController::class . ':shareWallet');

$app->get('/wallet-user-type', WalletController::class . ':lisUserWalletsByType');
$app->get('/wallet', WalletController::class . ':listWallets');
$app->get('/wallet/[{idWallet}]', WalletController::class . ':getWalletById');
$app->get('/wallet-user', WalletController::class . ':listWalletUser');

$app->post('/transaction', TransactionController::class . ':registerTransaction');
$app->get('/transaction-type', TransactionController::class . ':getUserTransactionsByType');
$app->get('/transaction-total', TransactionController::class . ':getUserTotalTransactionsByType');

$app->post('/goal', GoalController::class . ':registerGoal');
$app->get('/goal', GoalController::class . ':listGoals');


//Need authentication
$app->group('',function() use ($app){
    $app->get('/person', PersonController::class . ':listPersons');

    $app->get('/verifica-autenticacao', function ($request, $response, $args) {
        return $response
                    ->withStatus(200);
    });
    
})
->add(
    function($request, $response, $next){
        $token = $request->getAttribute("jwt");

        $_SESSION["idUsuario"] = $token['sub'];
        $_SESSION['idPessoa'] = $token['idPessoa'];
        $_SESSION['login'] = $token['login'];;
        
        $expireDate = date_format(new \DateTime($token['dateExpire']), 'Y-m-d H:i:s');
        
        $now = getenv('DATA_HORA_SISTEMA');
    
        if($expireDate < $now)
            return $response->withJson([
                                "message" => 'Token expirou. Favor faça login'
                            ])
                            ->withStatus(401);

        // if($token['idEmpresa'] == '')
        //     return $response->withJson([
        //                     "message" => 'Token invalido.'
        //                 ])
        //                 ->withStatus(401);
        $response = $next($request, $response);
        return $response;
    }
)
->add(
    new JwtAuthentication([
        "secure" => false,
        "secret" => getenv('JWT_SECRET_KEY'),
        "attribute" => "jwt",
        "relaxed" => ["localhost", "my-green.herokuapp.com"],
        "error" => function ($response, $arguments) {
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response
                ->withHeader("Content-Type", "application/json")
                ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ])
);

$app->run();
