<?php

namespace App\Models\PostgreSQL;

final class WalletModel
{ 
    private $idWallet;
    private $idUser;
    private $balance;
    private $dateTimeRegister;


    /**
     * Get the value of idWallet
     */ 
    public function getIdWallet(): int
    {
        return $this->idWallet;
    }

    /**
     * Set the value of idWallet
     *
     * @return  self
     */ 
    public function setIdWallet($idWallet): WalletModel
    {
        $this->idWallet = $idWallet;

        return $this;
    }

    /**
     * Get the value of idUser
     */ 
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser): WalletModel
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of balance
     */ 
    public function getBalance(): double
    {
        return $this->balance;
    }

    /**
     * Set the value of balance
     *
     * @return  self
     */ 
    public function setBalance($balance): WalletModel
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get the value of dateTimeRegister
     */ 
    public function getDateTimeRegister(): string
    {
        return $this->dateTimeRegister;
    }

    /**
     * Set the value of balance
     *
     * @return  self
     */ 
    public function setDateTimeRegister($dateTimeRegister): WalletModel
    {
        $this->dateTimeRegister = $dateTimeRegister;

        return $this;
    }

}