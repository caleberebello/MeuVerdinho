<?php

namespace App\Models\PostgreSQL;

final class TransactionModel
{ 
    private $idTransaction;
    private $idWallet;
    private $value;
    private $periodic;
    private $registerType;
    private $dateTimeRegister;


    /**
     * Get the value of idTransaction
     */ 
    public function getIdTransaction(): int
    {
        return $this->idTransaction;
    }

    /**
     * Set the value of idTransaction
     *
     * @return  self
     */ 
    public function setIdTransaction($idTransaction): TransactionModel
    {
        $this->idTransaction = $idTransaction;

        return $this;
    }

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
     * Get the value of value
     */ 
    public function getValue(): double
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value): WalletModel
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of periodic
     */ 
    public function getPeriodic(): string
    {
        return $this->periodic;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setPeriodic($periodic): WalletModel
    {
        $this->periodic = $periodic;

        return $this;
    }

    /**
     * Get the value of registerType
     */ 
    public function getRegisterType(): string
    {
        return $this->registerType;
    }

    /**
     * Set the value of registerType
     *
     * @return  self
     */ 
    public function setRegisterType($registerType): WalletModel
    {
        $this->registerType = $registerType;

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
     * Set the value of dateTimeRegister
     *
     * @return  self
     */ 
    public function setDateTimeRegister($dateTimeRegister): WalletModel
    {
        $this->dateTimeRegister = $dateTimeRegister;

        return $this;
    }

}