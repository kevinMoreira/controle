<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

     class Pessoa{
        private $nome;
        private $cpf;
        private $dataNasc;
        private $telefone;
        private $celular;
        private $email;
        private $cep;
        private $endereco;
        private $numero;
        private $complemento;
        private $bairo;
        private $cidade;
        private $foto;
        
        function __construct($nome, $cpf, $dataNasc, $telefone, $celular, $email, $cep, $endereco, $numero, $complemento, $bairo, $cidade, $foto) {
            $this->nome = $nome;
            $this->cpf = $cpf;
            $this->dataNasc = $dataNasc;
            $this->telefone = $telefone;
            $this->celular = $celular;
            $this->email = $email;
            $this->cep = $cep;
            $this->endereco = $endereco;
            $this->numero = $numero;
            $this->complemento = $complemento;
            $this->bairo = $bairo;
            $this->cidade = $cidade;
            $this->foto = $foto;
        }

        
        function getNome() {
            return $this->nome;
        }

        function setNome($nome) {
            $this->nome = $nome;
        }        
        
        function getCpf() {
            return $this->cpf;
        }

        function getDataNasc() {
            return $this->dataNasc;
        }

        function getTelefone() {
            return $this->telefone;
        }

        function getCelular() {
            return $this->celular;
        }

        function getEmail() {
            return $this->email;
        }

        function getCep() {
            return $this->cep;
        }

        function getEndereco() {
            return $this->endereco;
        }

        function getNumero() {
            return $this->numero;
        }

        function getComplemento() {
            return $this->complemento;
        }

        function getBairo() {
            return $this->bairo;
        }

        function getCidade() {
            return $this->cidade;
        }

        function getFoto() {
            return $this->foto;
        }

        function setCpf($cpf) {
            $this->cpf = $cpf;
        }

        function setDataNasc($dataNasc) {
            $this->dataNasc = $dataNasc;
        }

        function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        function setCelular($celular) {
            $this->celular = $celular;
        }

        function setEmail($email) {
            $this->email = $email;
        }

        function setCep($cep) {
            $this->cep = $cep;
        }

        function setEndereco($endereco) {
            $this->endereco = $endereco;
        }

        function setNumero($numero) {
            $this->numero = $numero;
        }

        function setComplemento($complemento) {
            $this->complemento = $complemento;
        }

        function setBairo($bairo) {
            $this->bairo = $bairo;
        }

        function setCidade($cidade) {
            $this->cidade = $cidade;
        }

        function setFoto($foto) {
            $this->foto = $foto;
        }


        
        
        
        
        
        
    }
?>