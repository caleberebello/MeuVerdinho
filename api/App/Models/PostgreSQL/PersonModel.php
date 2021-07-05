<?php

namespace App\Models\PostgreSQL;

class PersonModel
{
	private $idPerson;
	private $name;
	private $birthDate;
	private $phone=null;
	private $imgPath=null;

    /**
     * Get the value of idPerson
     */ 
    public function getIdPerson(): int
    {
        return $this->idPerson;
    }

    /**
     * Set the value of idPerson
     *
     * @return  self
     */ 
    public function setIdPerson($idPerson): PersonModel
    {
        $this->idPerson = $idPerson;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name): PersonModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of birthDate
     */ 
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * Set the value of birthDate
     *
     * @return  self
     */ 
    public function setBirthDate($birthDate): PersonModel
    {
        $this->birthDate = $birthDate;

        return $this;
    }

	/**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of birthDate
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

	/**
     * Get the value of imgPath
     */ 
    public function getImgPath()
    {
        return $this->imgPath;
    }

    /**
     * Set the value of birthDate
     *
     * @return  self
     */ 
    public function setImgPath($imgPath)
    {
        $this->imgPath = $imgPath;

        return $this;
    }

}