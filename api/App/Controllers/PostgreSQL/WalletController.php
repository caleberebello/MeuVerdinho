<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\Connection;

use App\DAO\PostgreSQL\WalletDAO;
use App\Models\PostgreSQL\WalletModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class WalletController extends Connection
{
    
    public function listWallets(Request $request, Response $response, array $args): Response
    {
        $walletDAO = new WalletDAO();

        $data = $walletDAO->listWallets();

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

    public function getWalletById(Request $request, Response $response, array $args): Response
    {
        $query = $request->getQueryParams();

        $walletDAO = new WalletDAO();

        $data = $walletDAO->getWalletById($query['idWallet']);

        $result = [
            'message' => [
                'pt' => null,
                'en' => null
            ],
            'result' => $data
        ];

        $response = $response
            ->withjson($data);

        return $response;
    }

    public function listWalletUser(Request $request, Response $response, array $args): Response
    {
        $walletDAO = new WalletDAO();

        $data = $walletDAO->listWalletUser();

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

    public function lisUserWalletsByType(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $idUser = $data['usuario_id'];
        $type = $data['tipo_carteira'];

        $walletDAO = new WalletDAO();

        $data = $walletDAO->listUserWalletByType($idUser, $type);

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

    public function registerWallet(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        
        $walletModel = new WalletModel();
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

        $walletModel
            ->setIdUser($data['usuario_id'])
            ->setBalance(0.0)
            ->setTypeWallet($data['tipo_carteira'])
            ->setDateTimeRegister(getenv('DATA_HORA_SISTEMA'));

        try{
            $idWallet = $walletDAO->registerWallet($walletModel);

            if($idWallet){
                $result = [
                    'message' => [
                        'pt' => 'Carteira adicionada.',
                        'en' => 'Wallet added.'
                    ],
                    'result' => null
                ]; 

                $this->pdo->commit();
                return $response->withjson($result)->withStatus(200);

            }else{
                $this->pdo->rollBack();
                return $response->withjson($result)->withStatus(406);
            }

        }catch (Exception $e) {
            $this->pdo->rollBack();
            return $response;
        }
    }

    public function shareWallet(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        
        $walletModel = new WalletModel();
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

        $walletModel
            ->setIdWallet($data['carteira_id'])
            ->setIdUser($data['usuario_id']);

        try{
            $idWalletUser = $walletDAO->shareWallet($walletModel);

            if($idWalletUser){
                $result = [
                    'message' => [
                        'pt' => 'Carteira compartilhada com sucesso.',
                        'en' => 'Successfully shared wallet.'
                    ],
                    'result' => null
                ]; 

                $this->pdo->commit();
                return $response->withjson($result)->withStatus(200);

            }else{
                $this->pdo->rollBack();
                return $response->withjson($result)->withStatus(406);
            }

        }catch (Exception $e) {
            $this->pdo->rollBack();
            return $response;
        }
    }

}