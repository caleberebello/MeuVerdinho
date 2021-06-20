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

    public function listAdmeasurements(): array
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

    public function registerAdmeasurement(AdmeasurementModel $admeasurementModel)
    {
        $statement = $this->pdo
            ->prepare(" INSERT INTO transfusao.afericao(
                            idtipo_afericao,
                            idato_transfusional_itens, 
                            temperatura,
                            pressao_arterial_sistolica,
                            pressao_arterial_diastolica,
                            saturacao,
                            frequencia_cardiaca,
                            frequencia_respiratoria,
                            data_hora_registro,
                            observacao)
                        VALUES (
                            :idtipo_afericao,
                            :idato_transfusional_itens, 
                            :temperatura,
                            :pressao_arterial_sistolica,
                            :pressao_arterial_diastolica,
                            :saturacao,
                            :frequencia_cardiaca,
                            :frequencia_respiratoria,
                            :data_hora_registro,
                            :observacao);
                        ");
        $statement->execute([
            ':idtipo_afericao' => $admeasurementModel->getIdTypeAdmeasurement(),
            ':idato_transfusional_itens' => $admeasurementModel->getIdTransfusionalAct_Itens(),
            ':temperatura' => $admeasurementModel->getTemperature(),
            ':pressao_arterial_sistolica' => $admeasurementModel->getSystolicBloodPressure(),
            ':pressao_arterial_diastolica' => $admeasurementModel->getDiastolicBloodPressure(),
            ':saturacao' => $admeasurementModel->getSaturation(),
            ':frequencia_cardiaca' => $admeasurementModel->getHeartRate(),
            ':frequencia_respiratoria' => $admeasurementModel->getRespiratoryRate(),
            ':data_hora_registro' => $admeasurementModel->getDateTimeRegister(),
            ':observacao' => $admeasurementModel->getObservation(),
        ]);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $idAdmeasurement =  $this->pdo->lastInsertId();
    
        return $idAdmeasurement;
    }

    public function checkIfTransfusionalItemIsUsed($idTransfusionalAct_Itens)
    {
        $statement = $this->pdo
            ->prepare(" SELECT 
                            idato_transfusional_itens
                        FROM transfusao.afericao
                        WHERE idato_transfusional_itens = :idAtoTransfusional_Itens
                        ");
        $statement->bindValue(':idAtoTransfusional_Itens', $idTransfusionalAct_Itens);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $isUsed = false;
        if(count($result) > 0)
            $isUsed = true;
        
        return $isUsed;
    }
    
}