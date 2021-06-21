<?php

namespace App\Models\PostgreSQL;

final class TokenModel
{ 
    private $idToken;
    private $idUser;
    private $token;
    private $refreshToken;
    private $dateExpire;


    /**
     * Get the value of idToken
     */ 
    public function getIdToken(): int
    {
        return $this->idToken;
    }

    /**
     * Set the value of idToken
     *
     * @return  self
     */ 
    public function setIdToken($idToken): TokenModel
    {
        $this->idToken = $idToken;

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
    public function setIdUser($idUser): TokenModel
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token): TokenModel
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of refreshToken
     */ 
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * Set the value of refreshToken
     *
     * @return  self
     */ 
    public function setRefreshToken($refreshToken): TokenModel
    {
        $this->refreshToken = $refreshToken;

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
     * Set the value of dateExpire
     *
     * @return  self
     */ 
    public function setDateExpire($dateExpire): TokenModel
    {
        $this->dateExpire = $dateExpire;

        return $this;
    }
}