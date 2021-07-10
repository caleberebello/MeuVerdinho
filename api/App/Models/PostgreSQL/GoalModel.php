<?php

namespace App\Models\PostgreSQL;

class GoalModel
{
	private $idGoal;
	private $value;
	private $deadline;
    private $idWallet;

    /**
     * Get the value of idGoal
     */ 
    public function getIdGoal(): int
    {
        return $this->idGoal;
    }

    /**
     * Set the value of idGoal
     *
     * @return  self
     */ 
    public function setIdGoal($idGoal): GoalModel
    {
        $this->idGoal = $idGoal;

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
    public function setValue($value): GoalModel
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of deadline
     */ 
    public function getDeadline(): string
    {
        return $this->deadline;
    }

    /**
     * Set the value of deadline
     *
     * @return  self
     */ 
    public function setDeadline($deadline): GoalModel
    {
        $this->deadline = $deadline;

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
     * Set the value of deadline
     *
     * @return  self
     */ 
    public function setIdWallet($idWallet): GoalModel
    {
        $this->idWallet = $idWallet;

        return $this;
    }

	
}