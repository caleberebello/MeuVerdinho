<?php

namespace App\Models\PostgreSQL;

final class UserModel
{ 
    private $idUser;
    private $idPerson;
    private $username;
    private $email;
    private $password;


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
    public function setIdUser($idUser): UserModel
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of idPerson
     */ 
    public function getIdPerson(): int
    {
        return $this->idPerson;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdPerson($idPerson): UserModel
    {
        $this->idPerson = $idPerson;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username): UserModel
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email): UserModel
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password): UserModel
    {
        $this->password = $password;

        return $this;
    }

}