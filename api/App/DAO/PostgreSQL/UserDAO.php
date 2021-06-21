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
                            pessoa_id,
                            username,
                            email, 
                            senha
                        ) VALUES (
                            :pessoa_id,
                            :username,
                            :email,
                            :senha   
                        );
            ');
        $statement->execute([
            'pessoa_id' => $user->getIdPerson(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'senha' => $user->getPassword()
        ]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $idUser =  $this->pdo->lastInsertId();

        return $idUser;
    }

    public function listUsers(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            u.usuario_id,
                            u.pessoa_id,
                            u.email,
                            u.username,
                            p.nome,
                            p.data_nascimento,
                            p.telefone,
                            p.img_path
                        FROM adm.usuario AS u

                        LEFT JOIN adm.pessoa AS p
                            ON u.pessoa_id = p.pessoa_id

                        ORDER BY usuario_id
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $response;
    }

    // public function queryUserRest(string $email): array
    // {
    //     $statement = $this->pdo
    //         ->prepare(' SELECT
    //                         u.idusuario,
    //                         p.nome,
    //                         u.login
    //                     FROM administracao.usuario u
    //                     join administracao.pessoa p
    //                         on u.idpessoa = p.idpessoa
    //                     WHERE login = :email
    //         ');
    //     $statement->bindParam('email', $email);
    //     $statement->execute();
    //     $user = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //     return $user;
    // }

    // public function updatePassword(UserModel $user): array
    // {
    //     $statement = $this->pdo
    //         ->prepare(' UPDATE administracao.usuario SET
    //                         senha = :senha
    //                     WHERE login = :login
                
    //         ');
    //     $statement->execute([
    //         'login'=>$user->getLogin(),
    //         'senha'=>$user->getPassword()
    //     ]);
    //     $user = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //     return $user;
    // }

    public function userLogin(string $email): ?UserModel
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            usuario_id,
                            pessoa_id,
                            email,
                            senha
                        FROM adm.usuario
                        WHERE email = :email
            ');
        $statement->bindParam('email', $email);
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($users) === 0)
            return null;
        
        $user = new UserModel();
        $user
            ->setIdUser($users[0]['usuario_id'])
            ->setIdPerson($users[0]['pessoa_id'])
            ->setEmail($users[0]['email'])
            ->setPassword($users[0]['senha']);

        return $user;
    }

    // public function getUserById(int $idUser)
    // {
    //     $statement = $this->pdo
    //         ->prepare(' SELECT 
    //                         idusuario,
    //                         idpessoa,
    //                         login,
    //                         ativo
    //                     FROM administracao.usuario
    //                     WHERE idusuario = :idusuario
    //                     ORDER BY idusuario,ativo
    //         ');
    //     $statement->bindParam('idusuario', $idUser);
    //     $statement->execute();
    //     $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
    //     return $response;
    // }

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