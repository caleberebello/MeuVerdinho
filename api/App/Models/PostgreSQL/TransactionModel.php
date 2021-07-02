<?php

namespace App\Models\PostgreSQL;

final class TransactionModel
{ 
    private $idTransaction;
    private $idWallet;
    private $description;
    private $value;
    private $dateExpire;
    private $recurrence;
    private $category;
    private $situation;
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
    public function setIdWallet($idWallet): TransactionModel
    {
        $this->idWallet = $idWallet;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setDescription($description): TransactionModel
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of value
     */ 
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value): TransactionModel
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of dateExpire
     */ 
    public function getDateExpire(): string
    {
        return $this->dateExpire;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setDateExpire($dateExpire): TransactionModel
    {
        $this->dateExpire = $dateExpire;

        return $this;
    }

    /**
     * Get the value of recurrence
     */ 
    public function getRecurrence(): string
    {
        return $this->recurrence;
    }

    /**
     * Set the value of recurrence
     *
     * @return  self
     */ 
    public function setRecurrence($recurrence): TransactionModel
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category): TransactionModel
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of situation
     */ 
    public function getSituation(): string
    {
        return $this->situation;
    }

    /**
     * Set the value of situation
     *
     * @return  self
     */ 
    public function setSituation($situation): TransactionModel
    {
        $this->situation = $situation;

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
    public function setregisterType($registerType): TransactionModel
    {
        $this->registerType = $registerType;

        return $this;
    }

}