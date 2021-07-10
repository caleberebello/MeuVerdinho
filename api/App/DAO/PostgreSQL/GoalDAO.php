<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Connection;
use App\Models\PostgreSQL\GoalModel;

final class GoalDAO extends Connection
{
    public function __construct(\PDO $connection = null)
    {
        parent::__construct(); 
        if (isset($connection)) {
            $this->pdo = $connection;
        }
    }

    public function listGoals(): array
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            *
                        FROM adm.meta
                        ORDER BY meta_id
                        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    // public function listGoalsByUser(int $idUser, string $type): array
    // {
    //     $statement = $this->pdo
    //         ->prepare(" SELECT 
    //                         *
    //                     FROM adm.carteira
    //                     WHERE usuario_id = :usuario_id
    //                         AND tipo_carteira = :tipo_carteira
    //                     ORDER BY carteira_id
    //                     ");
    //     $statement->bindValue('usuario_id', $idUser);
    //     $statement->bindValue('tipo_carteira', $type);
    //     $statement->execute();
    //     $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //     return $result;
    // }

    public function registerGoal(GoalModel $goalModel)
    {
        $statement = $this->pdo
            ->prepare(" INSERT INTO adm.meta(
                            valor,
                            prazo,
                            carteira_id
                            )
                        VALUES (
                            :valor,
                            :prazo,
                            :carteira_id);
                        ");
        $statement->execute([
            'valor' => $goalModel->getValue(),
            'prazo' => $goalModel->getDeadline(),
            'carteira_id' => $goalModel->getIdWallet()
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $idGoal =  $this->pdo->lastInsertId();
    
        return $idGoal;
    }

    public function updateGoal(GoalModel $goalModel)
    {
        $statement = $this->pdo
            ->prepare(" UPDATE adm.meta SET
                            valor = :valor,
                            prazo = :prazo,
                        WHERE carteira_id = :carteira_id
                            AND meta_id = :meta_id
                        ;");
        $statement->execute([
            'meta_id' => $goalModel->getIdGoal(),
            'valor' => $goalModel->getValue(),
            'prazo' => $goalModel->getDeadline(),
            'carteira_id' => $goalModel->getIdWallet()
        ]);
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