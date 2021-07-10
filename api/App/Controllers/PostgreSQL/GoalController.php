<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\Connection;

use App\DAO\PostgreSQL\GoalDAO;
use App\Models\PostgreSQL\GoalModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GoalController extends Connection
{
    
    public function listGoals(Request $request, Response $response, array $args): Response
    {
        $goalDAO = new GoalDAO();

        $data = $goalDAO->listGoals();

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

    // public function getGoalById(Request $request, Response $response, array $args): Response
    // {
    //     $query = $request->getQueryParams();

    //     $goalDAO = new GoalDAO();

    //     $data = $goalDAO->getGoalById($query['idGoal']);

    //     $result = [
    //         'message' => [
    //             'pt' => null,
    //             'en' => null
    //         ],
    //         'result' => $data
    //     ];

    //     $response = $response
    //         ->withjson($data);

    //     return $response;
    // }

    public function registerGoal(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        
        $goalModel = new GoalModel();
        $goalDAO = new GoalDAO($this->pdo);

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

        $goalModel
            ->setIdWallet($data['carteira_id'])
            ->setValue($data['valor'])
            ->setDeadline($data['prazo']);

        try{
            $idGoal = $goalDAO->registerGoal($goalModel);

            if($idGoal){
                $result = [
                    'message' => [
                        'pt' => 'Carteira adicionada.',
                        'en' => 'Goal added.'
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