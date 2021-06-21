<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\PersonModel;

final class PersonDAO extends Connection
{
    public function __construct(\PDO $connection = null)
    {
        parent::__construct(); 
        if (isset($connection)) {
            $this->pdo = $connection;
        }
    }

    public function listPersons(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            * 
                        FROM administracao.pessoa
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function checkCPF(string $cpf)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idpessoa,
                            naturalidade,
                            nome,
                            datanascimento,
                            sexo,
                            cpf,
                            rg,
                            nomemae,
                            nomepai,
                            email,
                            telefone1,
                            telefone2
                        FROM administracao.pessoa
                        WHERE cpf = :cpf
                        ORDER BY idpessoa
            ');
        $statement->bindValue('cpf', $cpf);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function checkEmail(string $email)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idpessoa,
                            naturalidade,
                            nome,
                            datanascimento,
                            sexo,
                            cpf,
                            nomemae,
                            email,
                            telefone1,
                            telefone2
                        FROM administracao.pessoa
                        WHERE email = :email
                        ORDER BY idpessoa
            ');
        $statement->bindValue('email', $email);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function checkRG(string $rg)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idpessoa,
                            naturalidade,
                            nome,
                            datanascimento,
                            sexo,
                            cpf,
                            nomemae,
                            email,
                            telefone1,
                            telefone2
                        FROM administracao.pessoa
                        WHERE rg = :rg
                        ORDER BY idpessoa
            ');
        $statement->bindValue('rg', $rg);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function getPersonById(int $id): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idpessoa,
                            naturalidade,
                            nome,
                            datanascimento,
                            sexo,
                            cpf,
                            nomemae,
                            email,
                            telefone1,
                            telefone2
                        FROM administracao.pessoa
                        WHERE idpessoa = :id
                        ORDER BY idpessoa
            ');
        $statement->bindValue('id', $id);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function registerPerson(PersonModel $person)
    {   
        $statement = $this->pdo
            ->prepare(' SELECT 
                            *
                        FROM administracao.pessoa
                        WHERE
                            :cpf = cpf
                            OR
                            :email = email
                        ;');
        $statement->execute([
            'cpf' => $person->getCpf(),
            'email' => $person->getEmail()
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);    
        //Existe uma pessoa cadastrada com o CPF
        if ($result){
            return null;
        }
        //Não existe uma pessoa com este CPF, então pode continuar com o cadastro
        $statement = $this->pdo
            ->prepare('INSERT INTO administracao.pessoa (
                naturalidade,
                nome, 
                datanascimento, 
                sexo, 
                cpf, 
                rg, 
                nomemae, 
                nomepai, 
                email, 
                telefone1, 
                telefone2
            )
            VALUES(
                :naturalidade,
                :nome, 
                :datanascimento, 
                :sexo, 
                :cpf, 
                :rg,
                :nomemae, 
                :nomepai, 
                :email, 
                :telefone1, 
                :telefone2
            );');

        $statement->execute([
            'naturalidade' => $person->getNaturalness(),
            'nome' => $person->getName(),
            'datanascimento' => $person->getBirth(),
            'sexo' => $person->getGender(),
            'cpf' => $person->getCpf(),
            'rg' => $person->getRg(),
            'nomemae' => $person->getMotherName(),
            'nomepai' => $person->getFatherName(),
            'email' => $person->getEmail(),
            'telefone1' => $person->getPhone1(),
            'telefone2' => $person->getPhone2()
        ]);
        //$result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $idPerson =  $this->pdo->lastInsertId();   

        return $idPerson;
    }

    public function updatePersonData(PersonModel $person): array
    {
        
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.pessoa SET
                            naturalidade = :naturalidade,
                            nome = :nome, 
                            datanascimento = :datanascimento, 
                            sexo = :sexo, 
                            cpf = :cpf,
                            rg = :rg,
                            nomemae = :nomemae,
                            nomepai = :nomepai,
                            email = :email, 
                            telefone1 = :telefone1, 
                            telefone2 = :telefone2
                        WHERE
                            cpf = :cpf
        ;');

        $statement->execute([
            'naturalidade' => $person->getNaturalness(),
            'nome' => $person->getName(),
            'datanascimento' => $person->getBirth(),
            'sexo' => $person->getGender(),
            'cpf' => $person->getCpf(),
            'rg' => $person->getRg(),
            'nomemae' => $person->getMotherName(),
            'nomepai' => $person->getFatherName(),
            'email' => $person->getEmail(),
            'telefone1' => $person->getPhone1(),
            'telefone2' => $person->getPhone2()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function updatePersonWithId(PersonModel $person): array
    {
        
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.pessoa SET
                            naturalidade = :naturalidade,
                            nome = :nome, 
                            datanascimento = :datanascimento, 
                            sexo = :sexo, 
                            cpf = :cpf,
                            rg = :rg,
                            nomemae = :nomemae,
                            nomepai = :nomepai,
                            email = :email, 
                            telefone1 = :telefone1, 
                            telefone2 = :telefone2
                        WHERE
                            idpessoa = :idpessoa
        ;');

        $statement->execute([
            'idpessoa' => $person->getIdPerson(),
            'naturalidade' => $person->getNaturalness(),
            'nome' => $person->getName(),
            'datanascimento' => $person->getBirth(),
            'sexo' => $person->getGender(),
            'cpf' => $person->getCpf(),
            'rg' => $person->getRg(),
            'nomemae' => $person->getMotherName(),
            'nomepai' => $person->getFatherName(),
            'email' => $person->getEmail(),
            'telefone1' => $person->getPhone1(),
            'telefone2' => $person->getPhone2()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function deletePerson(int $idPerson)
    {
        $statement = $this->pdo
            ->prepare(" DELETE FROM administracao.pessoa                            
                        WHERE idpessoa = :idpessoa
                        ;");
        $statement->bindValue(':idpessoa', $idPerson);
        $statement->execute();
        $success = $statement->rowCount() === 1;
        
        return $success;
    }

    public function checkIfCurrentCpfIsEqual(PersonModel $person)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            cpf
                        FROM administracao.pessoa 
                        WHERE cpf = :cpf
                        AND idpessoa = :idpessoa
            ');
        $statement->execute([
            ':idpessoa' => $person->getIdPerson(),
            ':cpf' => $person->getCpf()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $exist = false;
        if(count($result) > 0){
            $exist = true;
        }
        
        return $exist;
    }

    public function checkIfCurrentRgIsEqual(PersonModel $person)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            rg
                        FROM administracao.pessoa 
                        WHERE rg = :rg
                        AND idpessoa = :idpessoa
            ');
        $statement->execute([
            ':idpessoa' => $person->getIdPerson(),
            ':rg' => $person->getRg()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $exist = false;
        if(count($result) > 0){
            $exist = true;
        }
        
        return $exist;
    }

    public function checkIfCurrentEmailIsEqual(PersonModel $person)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            email
                        FROM administracao.pessoa 
                        WHERE email = :email
                        AND idpessoa = :idpessoa
            ');
        $statement->execute([
            ':idpessoa' => $person->getIdPerson(),
            ':email' => $person->getEmail()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $exist = false;
        if(count($result) > 0){
            $exist = true;
        }
        
        return $exist;
    }
}