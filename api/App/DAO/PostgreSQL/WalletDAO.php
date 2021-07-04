<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\WalletModel;

final class WalletDAO extends Connection
{
    public function __construct(\PDO $connection = null)
    {
        parent::__construct(); 
        if (isset($connection)) {
            $this->pdo = $connection;
        }
    }

    public function listWallets(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            *
                        FROM adm.carteira
                        ORDER BY carteira_id
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function listWalletUser(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            *
                        FROM adm.carteira_usuario
                        ORDER BY carteira_id
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function listUserWalletByType(int $idUser, string $type): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            *
                        FROM adm.carteira
                        WHERE usuario_id = :usuario_id
                            AND tipo_carteira = :tipo_carteira
                        ORDER BY carteira_id
                        ");
        $statement->bindValue('usuario_id', $idUser);
        $statement->bindValue('tipo_carteira', $type);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerWallet(WalletModel $walletModel)
    {
        $statement = $this->pdo
            ->prepare(" INSERT INTO adm.carteira(
                            usuario_id,
                            saldo,
                            tipo_carteira,
                            data_registro
                            )
                        VALUES (
                            :usuario_id,
                            :saldo,
                            :tipo_carteira,
                            :data_registro);
                        ");
        $statement->execute([
            'usuario_id' => $walletModel->getIdUser(),
            'saldo' => $walletModel->getBalance(),
            'tipo_carteira' => $walletModel->getTypeWallet(),
            'data_registro' => $walletModel->getDateTimeRegister()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $idWallet =  $this->pdo->lastInsertId();
    
        return $idWallet;
    }

    public function updateWalletBalance(WalletModel $walletModel)
    {
        $statement = $this->pdo
            ->prepare(" UPDATE adm.carteira SET
                            saldo = :saldo
                        WHERE carteira_id = :carteira_id
                        ;");
        $statement->execute([
            'carteira_id' => $walletModel->getIdWallet(),
            'saldo' => $walletModel->getBalance(),
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
           
        return $result;
    }

    public function shareWallet(WalletModel $walletModel)
    {
        $statement = $this->pdo
            ->prepare(" INSERT INTO adm.carteira_usuario(
                            carteira_id,
                            usuario_id
                            )
                        VALUES (
                            :carteira_id,
                            :usuario_id);
                        ");
        $statement->execute([
            'carteira_id' => $walletModel->getIdWallet(),
            'usuario_id' => $walletModel->getIdUser()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $idWallet =  $this->pdo->lastInsertId();
    
        return $idWallet;
    }

    public function checkWalletType(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            tipo_carteira
                        FROM adm.carteira
                        ORDER BY carteira_id
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getWalletById(int $idWallet): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            *
                        FROM adm.carteira
                        WHERE carteira_id = :carteira_id
                        ");
        $statement->bindValue('carteira_id', $idWallet);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }
    
}