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
                        FROM adm.pessoa
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function checkEmail(string $email)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idpessoa,
                            nome,
                            data_nascimento,
                            telefone
                        FROM adm.pessoa
                        WHERE email = :email
                        ORDER BY pessoa_id
            ');
        $statement->bindValue('email', $email);
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
            ->prepare('INSERT INTO adm.pessoa (
                nome,
                data_nascimento,
                telefone,
                img_path
            )
            VALUES(
                :nome, 
                :data_nascimento, 
                :telefone,
                :img_path
            );');

        $statement->execute([
            'nome' => $person->getName(),
            'data_nascimento' => $person->getBirthDate(),
            'telefone' => $person->getPhone(),
            'img_path' => $person->getImgPath()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $idPerson =  $this->pdo->lastInsertId();   
        
        return $idPerson;
    }

    public function checkIfCurrentEmailIsEqual(PersonModel $person)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            email
                        FROM adm.pessoa 
                        WHERE email = :email
                        AND pessoa_id = :pessoa_id
            ');
        $statement->execute([
            ':pessoa_id' => $person->getIdPerson(),
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