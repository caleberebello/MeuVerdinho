<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\Connection;

use App\DAO\PostgreSQL\AdmeasurementDAO;
use App\Models\PostgreSQL\AdmeasurementModel;
use App\DAO\PostgreSQL\TransfusionalActDAO;
use App\Models\PostgreSQL\TransfusionalActModel;
use App\DAO\PostgreSQL\TransfusionalAct_ItensDAO;
use App\Models\PostgreSQL\TransfusionalAct_ItensModel;
use App\DAO\PostgreSQL\RequisitionDAO;
use App\DAO\PostgreSQL\RequisitionProductDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AdmeasurementController extends Connection
{
    
    public function listAdmeasurements(Request $request, Response $response, array $args): Response
    {
        $transfActDAO = new TransfusionalActDAO();
        $transfAct_ItensDAO = new TransfusionalAct_ItensDAO();
        $admeasurementDAO = new AdmeasurementDAO();

        $data = $admeasurementDAO->listAdmeasurements();

        foreach($data as &$admeasurement){
            $transfAct_Itens = $transfAct_ItensDAO->getTranfusionalItemById($admeasurement['idato_transfusional_itens']);
            $transfAct = $transfActDAO->summaryTransfusionalAct($transfAct_Itens[0]['idato_transfusional']);

            $admeasurement['transfusional-item'] = $transfAct_Itens;
            $admeasurement['transfusional'] = $transfAct;
        }

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
    

    // public function registerAdmeasurement(Request $request, Response $response, array $args): Response
    // {
    //     $data = $request->getParsedBody();
        
    //     $admeasurementModel = new AdmeasurementModel();
    //     $admeasurementDAO = new AdmeasurementDAO($this->pdo);

    //     $this->pdo->beginTransaction();

    //     # Error message for some unknown database problem
    //     $result = [
    //         'message' => [
    //             'pt' => 'Erro ao cadastrar. Por favor, verifique os dados e tente novamente!!',
    //             'en' => 'Error when registering. Please upload the data and try again!!'
    //         ],
    //         'result' => null
    //     ]; 
    //     $response = $response->withjson($result)->withStatus(406);

    //     $admeasurementModel
    //         ->setIdTypeAdmeasurement($data['idtipo_afericao'])
    //         ->setIdTransfusionalAct_Itens($data['idato_transfusional_itens'])
    //         ->setTemperature($data['temperatura'])
    //         ->setSystolicBloodPressure($data['pressao_arterial_sistolica'])
    //         ->setDiastolicBloodPressure($data['pressao_arterial_diastolica'])
    //         ->setSaturation($data['saturacao'])
    //         ->setHeartRate($data['frequencia_cardiaca'])
    //         ->setRespiratoryRate($data['frequencia_respiratoria'])
    //         ->setDateTimeRegister(getenv('DATA_HORA_SISTEMA'))
    //         ->setObservation($data['observacao']);
        
    //     #check if transfusional act itens is already in use
    //     if($admeasurementDAO->checkIfTransfusionalItemIsUsed($data['idato_transfusional_itens'])){
    //         $result = [
    //             'message' => [
    //                 'pt' => 'Item do ato transfusional já em uso.',
    //                 'en' => 'Transfusion item already in use.'
    //             ],
    //             'result' => null
    //         ];
    //     }

    //     try{
    //         #Register transfusional act
    //         $idAdmeasurement = $admeasurementDAO->registerAdmeasurement($admeasurementModel);

    //         if($idAdmeasurement){
    //             $result = [
    //                 'message' => [
    //                     'pt' => 'Aferição registrada com sucesso!',
    //                     'en' => 'Measurement recorded successfully!'
    //                 ],
    //                 'result' => null
    //             ]; 

    //             $this->pdo->commit();
    //             return $response->withjson($result)->withStatus(200);

    //         }else{
    //             $this->pdo->rollBack();
    //             return $response->withjson($result)->withStatus(406);
    //         }

    //     }catch (Exception $e) {
    //         $this->pdo->rollBack();
    //         return $response;
    //     }
    // }

    public function registerAdmeasurement(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        
        $transfActModel = new TransfusionalActModel();
        $transfActDAO = new TransfusionalActDAO($this->pdo);
        $transfAct_ItensModel = new TransfusionalAct_ItensModel();
        $transfAct_ItensDAO = new TransfusionalAct_ItensDAO($this->pdo);
        $requisitionDAO = new RequisitionDAO();
        $requisitionProductDAO = new RequisitionProductDAO();
        
        $admeasurementModel = new AdmeasurementModel();
        $admeasurementDAO = new AdmeasurementDAO($this->pdo);

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

        #get requisition product by id
        $requisitionProduct = $requisitionProductDAO->getRequisitionProductById($data['idProdutoRequisicao']);
        $requisition = $requisitionDAO->getRequisitionById($data['idRequisicao']);
        
        #check if status is 'transfusion_in_progress'
        // if($requisition[0]['idstatus_requisicao'] !== 7){
        //     $result = [
        //         'message' => [
        //             'pt' => 'Requisição com status inválido!',
        //             'en' => 'Request with invalid status!'
        //         ],
        //         'result' => null
        //     ]; 
        //     return $response;
        // }
        
        try{
            #check if this transfusional act already exists
            $idTransfusionaAct = null;
            $transfAct = $transfActDAO->getTransfusionalActByIdRequisition($data['idRequisicao']);
            if($transfAct){
                #Exists - get existing id
                $transfActModel
                    ->setIdTransfusionalAct($transfAct[0]['idato_transfusional']);

                $idTransfusionaAct = $transfActModel->getIdTransfusionalAct();
            }else{
                #Doesn't exists - fill model and register
                $transfActModel
                    ->setIdCompany($_SESSION['idEmpresa'])
                    ->setIdPatient($requisition[0]['idpaciente'])
                    ->setIdRequisition($data['idRequisicao'])
                    ->setDateTimeRegister(getenv('DATA_HORA_SISTEMA'));
                #Register transfusional act
                $idTransfusionaAct = $transfActDAO->registerTransfusionalAct($transfActModel);

            }

            if($idTransfusionaAct){

                $idTransfusionaAct_Itens = null;
                $transfAct_Itens = $transfAct_ItensDAO->getTranfusionalItemByBagNumber($idTransfusionaAct, $requisitionProduct[0]['numero_da_bolsa']);
                
                # Check if transfusional item already exists
                if($transfAct_Itens){
                    #If exists - do nothing
                    $idTransfusionaAct_Itens = $transfAct_Itens[0]['idato_transfusional_itens'];

                }else{
                    #If doesn't exists - register new item
                    $transfAct_ItensModel
                        ->setIdTransfusionalAct($idTransfusionaAct)
                        ->setBagNumber($requisitionProduct[0]['numero_da_bolsa'])
                        ->setIdProduct($requisitionProduct[0]['codigo_do_produto'])
                        ->setSequentialSeparation($requisitionProduct[0]['sequencial_separacao'])
                        ->setIntercurrence(null);
    
                    #Register transfusional itens
                    $idTransfusionaAct_Itens = $transfAct_ItensDAO->registerTransfusionalItens_Product($transfAct_ItensModel);

                }    

                if($idTransfusionaAct_Itens){

                    $admeasurementModel
                        ->setIdTypeAdmeasurement(1)
                        ->setIdTransfusionalAct_Itens($idTransfusionaAct_Itens)
                        ->setTemperature($data['temperatura'])
                        ->setSystolicBloodPressure($data['pressao_arterial_sistolica'])
                        ->setDiastolicBloodPressure($data['pressao_arterial_diastolica'])
                        ->setSaturation($data['saturacao'])
                        ->setHeartRate($data['frequencia_cardiaca'])
                        ->setRespiratoryRate($data['frequencia_respiratoria'])
                        ->setDateTimeRegister(getenv('DATA_HORA_SISTEMA'))
                        ->setObservation($data['observacao']);

                    #Register patient vitals
                    $idAdmesurement = $admeasurementDAO->registerAdmeasurement($admeasurementModel);

                    if($idAdmesurement){
                        $result = [
                            'message' => [
                                'pt' => 'Sinais vitais adicionado.',
                                'en' => 'Vital signs added.'
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