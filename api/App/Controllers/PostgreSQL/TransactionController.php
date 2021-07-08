<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\Connection;

use App\DAO\PostgreSQL\TransactionDAO;
use App\Models\PostgreSQL\TransactionModel;

use App\DAO\PostgreSQL\WalletDAO;
use App\Models\PostgreSQL\WalletModel;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TransactionController extends Connection
{
    
    public function listTransactions(Request $request, Response $response, array $args): Response
    {
        $transactionDAO = new TransactionDAO();

        $data = $transactionDAO->listTransactions();

        $result = [
            'message' => [
                'pt' => null,
                'en' => null
            ],
            'result' => $data
        ];

        $response = $response
            ->withjson($result);

        return $response;
    }

    public function getUserTransactionsByType(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $idWallet = $data['carteira_id'];
        $type = $data['tipo_registro'];

        $transactionDAO = new TransactionDAO();

        $data = $transactionDAO->getUserTransactionsByType($idWallet, $type);

        $result = [
            'message' => [
                'pt' => null,
                'en' => null
            ],
            'result' => $data
        ];

        $response = $response
            ->withjson($result);

        return $response;
    }

    public function getUserTotalTransactionsByType(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $idWallet = $data['carteira_id'];

        $transactionDAO = new TransactionDAO();

        $dataRevenue = $transactionDAO->getUserTransactionsByType($idWallet, 'R');
        $dataExpense = $transactionDAO->getUserTransactionsByType($idWallet, 'D');

        $totalRevenue = $this->getTotalTransaction($dataRevenue, 'R');
        $totalExpense = $this->getTotalTransaction($dataExpense, 'D');

        $result = [
            'message' => [
                'pt' => null,
                'en' => null
            ],
            'result' => [
                "total_receita" => $totalRevenue,
                "total_despesa" => $totalExpense
            ]
        ];

        $response = $response
            ->withjson($result);

        return $response;
    }

    public function registerTransaction(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        
        $transactionModel = new TransactionModel();
        $walletModel = new WalletModel();
        $transactionDAO = new TransactionDAO($this->pdo);
        $walletDAO = new WalletDAO($this->pdo);

        $this->pdo->beginTransaction();

        # Error message for some unknown database problem
        $result = [
            'message' => [
                'pt' => 'Erro ao cadastrar. Por favor, verifique os dados e tente novamente!!',
                'en' => 'Error when registering. Please upload the data and try again!!'
            ],
            'result' => null
        ]; 
        $response = $response->withjson($result)->withStatus(406);

        $transactionModel
            ->setDescription($data['descricao'])
            ->setValue($data['valor'])
            ->setDateExpire($data['data_vencimento'])
            ->setRecurrence($data['recorrencia'])
            ->setCategory($data['categoria'])
            ->setIdWallet($data['carteira_id'])
            ->setSituation($data['situacao'])
            ->setregisterType($data['tipo_registro']);

        try{
            $idTransaction = $transactionDAO->registerTransaction($transactionModel);

            if($idTransaction){
                $type = $transactionModel->getRegisterType();
                $wallet = $walletDAO->getWalletById($data['carteira_id']);

                if($type === 'R'){
                    $newBalance = $wallet['saldo'] + $data['valor'];

                }else if($type === 'D'){
                    $newBalance = $wallet['saldo'] - $data['valor'];

                }else{
                    $this->pdo->rollBack();
                    return $response->withjson($result)->withStatus(406);
                }
                
                $walletModel
                    ->setIdWallet($data['carteira_id'])
                    ->setBalance($newBalance);
                    
                if($walletDAO->updateWalletBalance($walletModel)){
                    $result = [
                        'message' => [
                            'pt' => 'Transação sucedida.',
                            'en' => 'Transaction successful.'
                        ],
                        'result' => null
                    ]; 
    
                    $this->pdo->commit();
                    return $response->withjson($result)->withStatus(200);
                }else{
                    $this->pdo->rollBack();
                    return $response->withjson($result)->withStatus(406);
                }   
                
            }else{
                $this->pdo->rollBack();
                return $response->withjson($result)->withStatus(406);
            }

        }catch (Exception $e) {
            $this->pdo->rollBack();
            return $response;
        }
    }

    private function getTotalTransaction(array $data, string $type){
        $total = 0.0;
        foreach($data as $transaction){
            if($transaction['tipo_registro'] === $type)
                $total += $transaction['valor'];
        }

        return $total;

    }

}