<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Fornecedor {
    public $idFornecedor;

    public $nome;
    public $cnpj;
    public $telefone;
    public $email;
    public $cep;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairo;
    public $cidade;
    public $uf;
    public $fornecedorId;
    public $status;


     public function getStatus() {
        return $this->status;
     }

     public function setStatus($status) {
         $this->status = $status;
    }

    public function getFornecedorId() {
        return $this->fornecedorId;
    }

    public function getUf() {
        return $this->uf;
    }

     public function setFornecedorId($fornecedorId) {
         $this->fornecedorId = $fornecedorId;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }
    
    public function getNome() {
        return $this->nome;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getBairro() {
        return $this->bairo;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function setBairro($bairo) {
        $this->bairo = $bairo;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }


    /**
     * @return mixed
     */
    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    /**
     * @param mixed $idFornecedor
     */
    public function setIdFornecedor($idFornecedor)
    {
        $this->idFornecedor = $idFornecedor;
    }

    /**
     * @return mixed
     */
    public function getBairo()
    {
        return $this->bairo;
    }

    /**
     * @param mixed $bairo
     */
    public function setBairo($bairo)
    {
        $this->bairo = $bairo;
    }
}