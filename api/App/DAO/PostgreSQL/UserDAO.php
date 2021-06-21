<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\UserModel;

use App\DAO\PostgreSQL\PersonDAO;

use App\Models\PostgreSQL\PersonModel;
final class UserDAO extends Connection
{
    public function __construct(\PDO $connection = null)
    {
        parent::__construct(); 
        if (isset($connection)) {
            $this->pdo = $connection;
        }
    }

    public function registerUser(UserModel $user)
    {
        $statement = $this->pdo
            ->prepare(' INSERT INTO adm.usuario ( 
                            email, 
                            senha
                        ) VALUES (
                            :email,
                            :senha   
                        );
            ');
        $statement->execute([
            'email'=>$user->getEmail(),
            'senha'=>$user->getPassword()
        ]);

        $idUser =  $this->pdo->lastInsertId();

        return $idUser;
    }

    public function listUsers(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            u.idusuario,
                            u.idpessoa,
                            u.login,
                            u.ativo
                        FROM administracao.usuario AS u
                        JOIN administracao.pessoa AS p
                        ON u.idpessoa = p.idpessoa
                        ORDER BY idusuario,ativo
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function queryUserRest(string $email): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT
                            u.idusuario,
                            p.nome,
                            u.login
                        FROM administracao.usuario u
                        join administracao.pessoa p
                            on u.idpessoa = p.idpessoa
                        WHERE login = :email
            ');
        $statement->bindParam('email', $email);
        $statement->execute();
        $user = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function updatePassword(UserModel $user): array
    {
        $statement = $this->pdo
            ->prepare(' UPDATE administracao.usuario SET
                            senha = :senha
                        WHERE login = :login
                
            ');
        $statement->execute([
            'login'=>$user->getLogin(),
            'senha'=>$user->getPassword()
        ]);
        $user = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function userLogin(string $user): ?UserModel
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            u.idusuario,
                            u.idpessoa,
                            u.login,
                            u.senha
                        FROM administracao.usuario u
                        WHERE u.login = :usuario
            ');
        $statement->bindParam('usuario', $user);
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($users) === 0)
            return null;
        
        $user = new UserModel();
        $user
            ->setIdUser($users[0]['idusuario'])
            ->setIdPerson($users[0]['idpessoa'])
            ->setLogin($users[0]['login'])
            ->setPassword($users[0]['senha']);

        return $user;
    }

    public function listUserCompany(string $login): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT e.idempresa, e.nome, e.endereco
                        FROM administracao.usuario u 
                        join administracao.usuario_empresa ue 
                            on u.idusuario = ue.idusuario 
                            and ue.ativo = 'T'
                        join administracao.empresa e 
                            on ue.idempresa = e.idempresa 
                        WHERE u.login = :login
            ");
        $statement->bindParam('login', $login);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    public function getUserById(int $idUser)
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idusuario,
                            idpessoa,
                            login,
                            ativo
                        FROM administracao.usuario
                        WHERE idusuario = :idusuario
                        ORDER BY idusuario,ativo
            ');
        $statement->bindParam('idusuario', $idUser);
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    // public function getTableInformationById(int $idUser)
    // {
    //     $statement = $this->pdo
    //         ->prepare(" SELECT 
    //                     us.idusuario, pe.idpessoa, us.login, 
    //                     pe.nome, pe.cpf, pe.datanascimento, oc.descricao as ocupacao_descricao,
    //                     pr.numero_conselho, pr.matricula, cp.sigla, pe.telefone1, pe.telefone2
                        
    //                     FROM administracao.usuario us
                        
    //                     JOIN administracao.pessoa pe
    //                     ON pe.idpessoa = us.idpessoa
    //                     AND us.idusuario = :idusuario

    //                     JOIN administracao.profissional pr
    //                     ON pe.idpessoa = pr.idpessoa
                        
    //                     JOIN administracao.profissional_ocupacao po
    //                     ON po.idprofissional = pr.idprofissional
    //                     AND po.idempresa = :idempresa
                        
    //                     JOIN administracao.conselho_profissional cp
    //                     ON cp.idconselho_profissional = pr.idconselho_profissional
                        
    //                     JOIN administracao.ocupacao oc
    //                     ON oc.idocupacao = po.idocupacao
    //         ");
    //     $statement->execute([
    //         'idempresa'=>$_SESSION['idEmpresa'],
    //         'idusuario'=>$idUser
    //     ]);
    //     $response = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //     return $response;
    // }
}