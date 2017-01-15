<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 14/07/2015
 * Time: 23:50
 */

class eEndereco {
    private $Logradouro;
    private $Bairro;
    private $Cidade;
    private $Estado;
    private $Cep;

    public function getLogradouro(){
        return $this->Logradouro;
    }

    public function getBairro(){
        return $this->Bairro;
    }

    public function getCidade(){
        return $this->Cidade;
    }

    public function getEstado(){
        return $this->Estado;
    }

    public function getCep(){
        return $this->Cep;
    }

    public function setLogradouro($logradouro){
        $this->Logradouro=$logradouro;
    }

    public function setBairro($bairro){
        $this->Bairro=$bairro;
    }

    public function setCidade(){
        $this->Cidade;
    }

    public function setEstado($estado){
        $this->Estado=$estado;
    }

    public function setCep($cep){
        $this->Cep=$cep;
    }
}