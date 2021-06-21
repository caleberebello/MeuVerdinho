<?php 

namespace App\Controllers\PostgreSQL;

use App\DAO\PostgreSQL\PersonDAO;
use App\Models\PostgreSQL\PersonModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PersonController
{

    public function registerPerson(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $personDAO = new PersonDAO();
        $person = new PersonModel();
        if(
        strlen($data['cpf']) != 11 || 
        strlen($data['nome']) == 0 || 
        strlen($data['dataNascimento']) == 0 || 
        strlen($data['sexo']) != 1 ||
        strlen($data['telefone1']) < 10 ||
        strlen($data['telefone1']) > 11 ||
        strlen($data['pessoa']['email']) > 80 ||
        strlen($data['pessoa']['email']) < 5
        ){
            $result = [
                'message' => [
                    'pt' => 'Existem informações invalidas.',
                    'en' => 'There is invalid information.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result);

            return $response->withStatus(406);
        }

        if($data){
            $person
            ->setNaturalness ($data['naturalidade'])
            ->setName ($data['nome'])
            ->setBirth ($data['dataNascimento'])
            ->setGender ($data['sexo'])
            ->setCpf ($data['cpf'])
            ->setMotherName ($data['nomeMae'])
            ->setEmail ($data['email'])
            ->setPhone1 ($data['telefone1']);

            if($personDAO->checkCPF($person->getCpf())){
                $result = [
                    'message' => [
                        'pt' => 'CPF já está cadastrado.',
                        'en' => 'CPF already registered.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result);
    
                return $response->withStatus(406);
            }

            if(@$data['rg'] != null){
                $person->setRg($data['rg']);

                if($data['rg'] != ""){
                    if(strlen($data['rg']) < 8 || strlen($data['rg']) > 20){
                        $result = [
                            'message' => [
                                'pt' => 'Existem informações invalidas.',
                                'en' => 'There is invalid information.'
                            ],
                            'result' => null
                        ]; 
                        $response = $response->withjson($result);
                        return $response->withStatus(406);
                    }
    
                    if($personDAO->checkRG($person->getRg())){
                        $result = [
                            'message' => [
                                'pt' => 'RG já está cadastrado.',
                                'en' => 'RG already registered.'
                            ],
                            'result' => null
                        ]; 
                        $response = $response->withjson($result);
            
                        return $response->withStatus(406);
                    }
                }
            }

            if(@$data['telefone2'] != null){
                $person->setPhone2($data['telefone2']);
                
                if($person->getPhone1() === $person->getPhone2()){
                    $result = [
                        'message' => [
                            'pt' => 'Telefone 2 não pode ser o mesmo. Tente outro.',
                            'en' => 'Phone 2 cannot be the same. Try another one.'
                        ],
                        'result' => null
                    ]; 
                    $response = $response->withjson($result);
                    return $response->withStatus(406);
                }

                if($data['telefone2'] != ""){
                    if(strlen($data['telefone2']) < 10 || strlen($data['telefone2']) > 11){
                        $result = [
                            'message' => [
                                'pt' => 'Existem informações invalidas.',
                                'en' => 'There is invalid information.'
                            ],
                            'result' => null
                        ]; 
                        $response = $response->withjson($result);
                        return $response->withStatus(406);
                    }
                }
            }

            if(@$data['nomePai'] != null){
                $person->setFatherName($data['nomePai']);
            }


            $idPerson = $personDAO->registerPerson($person); 

            if($idPerson){
                $result = [
                    'message' => [
                        'pt' => 'Pessoa cadastrado com sucesso.',
                        'en' => 'Person successfully registered.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result)->withStatus(200);
            }else {
                $result = [
                    'message' => [
                        'pt' => 'Erro ao cadastrar pessoa.',
                        'en' => 'Error registering person.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result)->withStatus(406);
            }
        }else{
            $result = [
                'message' => [
                    'pt' => 'Parametros não aceitaveis.',
                    'en' => 'Parameters are not acceptable.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(406);
        }
        
        return $response;
    }

    public function listPersons(Request $request, Response $response, array $args): Response
    {
        $person = new PersonDAO();

        $data = $person->listPersons();

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

    public function updatePersonData(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $personDAO = new PersonDAO();
        $person = new PersonModel();
        if(
            strlen($data['cpf']) != 11 || 
            strlen($data['nome']) == 0 || 
            strlen($data['dataNascimento']) == 0 || 
            strlen($data['sexo']) != 1 || 
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
            ){
                $result = [
                    'message' => [
                        'pt' => 'Existem informações invalidas.',
                        'en' => 'There is invalid information.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result);
    
                return $response->withStatus(401);
        }

        if($data){
            $person
            ->setNaturalness ($data['naturalidade'])
            ->setName ($data['nome'])
            ->setBirth ($data['dataNascimento'])
            ->setGender ($data['sexo'])
            ->setCpf ($data['cpf'])
            ->setMotherName ($data['nomeMae'])
            ->setEmail ($data['email'])
            ->setPhone1 ($data['telefone1'])
            ->setPhone2 ($data['telefone2']);
            
            $idPerson = $personDAO->updatePersonData($person);

            if($idPerson){
                $result = [
                    'message' => [
                        'pt' => 'Pessoa atualizada com sucesso.',
                        'en' => 'Successfully updated person.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result);
                
            }else {
                $result = [
                    'message' => [
                        'pt' => 'Erro ao atualizar pessoa.',
                        'en' => 'Error updating person.'
                    ],
                    'result' => null
                ]; 
                $response = $response->withjson($result)->withStatus(406);
            }
        }else{
            $result = [
                'message' => [
                    'pt' => 'Parametros não aceitaveis.',
                    'en' => 'Parameters are not acceptable.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result)->withStatus(406);
        }
        
        return $response;
    }

    public function checkCPF(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $cpf = $queryParams["cpf"];

        if(strlen($cpf) != 11){
            $result = [
                'message' => [
                    'pt' => 'CPF não cadastrado no sistema.',
                    'en' => 'CPF not registered in the system.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result);

            return $response->withStatus(401);
        }

        $person = new PersonDAO();
        $data = $person->checkCPF($cpf);

        if($data){
            $result = [
                'message' => [
                    'pt' => 'CPF cadastrado no sistema.',
                    'en' => 'CPF registered in the system.'
                ],
                'result' => null
            ]; 
            $response = $response->withjson($result);

            return $response->withStatus(200);
        }

        $result = [
            'message' => [
                'pt' => 'CPF não cadastrado no sistema.',
                'en' => 'CPF not registered in the system.'
            ],
            'result' => null
        ]; 
        $response = $response->withjson($result);

        return $response->withStatus(406);
    }
}