<?php

namespace App\Models\PostgreSQL;

class PersonModel
{
	private $idPerson;
	private $idUser;
	private $name;
	private $birthDate;
	private $phone;
	private $imgPath;

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
    public function setIdUser($idUser): PersonModel
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): double
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
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Set the value of birthDate
     *
     * @return  self
     */ 
    public function setPhone($phone): PersonModel
    {
        $this->phone = $phone;

        return $this;
    }

	/**
     * Get the value of imgPath
     */ 
    public function getImgPath(): string
    {
        return $this->imgPath;
    }

    /**
     * Set the value of birthDate
     *
     * @return  self
     */ 
    public function setImgPath($imgPath): PersonModel
    {
        $this->imgPath = $imgPath;

        return $this;
    }

}