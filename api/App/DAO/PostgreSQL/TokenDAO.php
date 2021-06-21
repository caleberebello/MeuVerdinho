<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\TokenModel;

final class TokenDAO extends Connection
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function createToken(TokenModel $token): void
    {
        $statement = $this->pdo
            ->prepare('INSERT INTO administracao.token
                (
                    token,
                    idusuario,
                    refreshtoken,
                    dataexpira
                )
                VALUES
                (
                    :token,
                    :idUsuario,
                    :refreshToken,
                    :dataExpira
                )
            ');
        $statement->execute([
            'token' => $token->getToken(),
            'idUsuario' => $token->getIdUser(),
            'refreshToken' => $token->getRefreshToken(),
            'dataExpira' => $token->getDateExpire()
        ]);
        
    }
    
}