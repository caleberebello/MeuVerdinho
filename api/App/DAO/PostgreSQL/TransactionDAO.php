<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\TransactionModel;

final class TransactionDAO extends Connection
{
    public function __construct(\PDO $connection = null)
    {
        parent::__construct(); 
        if (isset($connection)) {
            $this->pdo = $connection;
        }
    }

    public function listTransactions(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            *
                        FROM adm.transacao
                        ORDER BY carteira_id
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerTransaction(TransactionModel $transactionModel)
    {
        $statement = $this->pdo
            ->prepare(" INSERT INTO adm.transacao(
                            carteira_id,
                            descricao,
                            valor,
                            data_vencimento,
                            recorrencia,
                            categoria,
                            situacao,
                            tipo_registro)
                        VALUES (
                            :carteira_id,
                            :descricao,
                            :valor,
                            :data_vencimento,
                            :recorrencia,
                            :categoria,
                            :situacao,
                            :tipo_registro);
                        ");
        $statement->execute([
            'carteira_id' => $transactionModel->getIdWallet(),
            'descricao' => $transactionModel->getDescription(),
            'valor' => $transactionModel->getValue(),
            'data_vencimento' => $transactionModel->getDateExpire(),
            'recorrencia' => $transactionModel->getRecurrence(),
            'categoria' => $transactionModel->getCategory(),
            'situacao' => $transactionModel->getSituation(),
            'tipo_registro' => $transactionModel->getRegisterType()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $idTransaction =  $this->pdo->lastInsertId();
    
        return $idTransaction;
    }

    public function getUserTransactionsByType(int $idWallet, string $type)
    {
        $statement = $this->pdo
            ->prepare(" SELECT
                            carteira_id,
                            descricao,
                            valor,
                            data_vencimento,
                            recorrencia,
                            categoria,
                            situacao,
                            tipo_registro
                        FROM adm.transacao
                        WHERE carteira_id = :carteira_id
                            AND tipo_registro = :tipo_registro
                        ");
        $statement->bindValue('carteira_id', $idWallet);
        $statement->bindValue('tipo_registro', $type);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    
        return $result;
    }


    
}