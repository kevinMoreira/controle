<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

     class Pessoa{
         public $nome;
         public $cpf;
         public $dataNasc;
         public $telefone;
         public $celular;
         public $email;
         public $cep;
         public $endereco;
         public $numero;
         public $complemento;
         public $bairo;
         public $cidade;
         public $foto;
         public $status;
         public $uf;
         public $estado;
         public $idOrganizacao;
         public $dataHoraCadastro;
         public $dataHoraAtualizacao;
         public $idUsuario;
         public $idUsuarioAtulaizacao;

         /**
          * @return mixed
          */
         public function getDataHoraAtualizacao()
         {
             return $this->dataHoraAtualizacao;
         }

         /**
          * @param mixed $dataHoraAtualizacao
          */
         public function setDataHoraAtualizacao($dataHoraAtualizacao)
         {
             $this->dataHoraAtualizacao = $dataHoraAtualizacao;
         }

         /**
          * @return mixed
          */
         public function getIdUsuarioAtulaizacao()
         {
             return $this->idUsuarioAtulaizacao;
         }

         /**
          * @param mixed $idUsuarioAtulaizacao
          */
         public function setIdUsuarioAtulaizacao($idUsuarioAtulaizacao)
         {
             $this->idUsuarioAtulaizacao = $idUsuarioAtulaizacao;
         }

         /**
          * @return mixed
          */
         public function getDataHoraCadastro()
         {
             return $this->dataHoraCadastro;
         }

         /**
          * @param mixed $dataHoraCadastro
          */
         public function setDataHoraCadastro($dataHoraCadastro)
         {
             $this->dataHoraCadastro = $dataHoraCadastro;
         }


        function __construct() {

        }

         /**
          * @return mixed
          */
         public function getIdOrganizacao()
         {
             return $this->idOrganizacao;
         }

         /**
          * @param mixed $idOrganizacao
          */
         public function setIdOrganizacao($idOrganizacao)
         {
             $this->idOrganizacao = $idOrganizacao;
         }
         

         /**
          * @return mixed
          */
         public function getEstado()
         {
             return $this->estado;
         }

         /**
          * @param mixed $estado
          */
         public function setEstado($estado)
         {
             $this->estado = $estado;
         }

         
         /**
          * @return mixed
          */
         public function getNome()
         {
             return $this->nome;
         }

         /**
          * @param mixed $nome
          */
         public function setNome($nome)
         {
             $this->nome = $nome;
         }

         /**
          * @return mixed
          */
         public function getCpf()
         {
             return $this->cpf;
         }

         /**
          * @param mixed $cpf
          */
         public function setCpf($cpf)
         {
             $this->cpf = $cpf;
         }

         /**
          * @return mixed
          */
         public function getDataNasc()
         {
             return $this->dataNasc;
         }

         /**
          * @param mixed $dataNasc
          */
         public function setDataNasc($dataNasc)
         {
             $this->dataNasc = $dataNasc;
         }

         /**
          * @return mixed
          */
         public function getTelefone()
         {
             return $this->telefone;
         }

         /**
          * @param mixed $telefone
          */
         public function setTelefone($telefone)
         {
             $this->telefone = $telefone;
         }

         /**
          * @return mixed
          */
         public function getCelular()
         {
             return $this->celular;
         }

         /**
          * @param mixed $celular
          */
         public function setCelular($celular)
         {
             $this->celular = $celular;
         }

         /**
          * @return mixed
          */
         public function getEmail()
         {
             return $this->email;
         }

         /**
          * @param mixed $email
          */
         public function setEmail($email)
         {
             $this->email = $email;
         }

         /**
          * @return mixed
          */
         public function getCep()
         {
             return $this->cep;
         }

         /**
          * @param mixed $cep
          */
         public function setCep($cep)
         {
             $this->cep = $cep;
         }

         /**
          * @return mixed
          */
         public function getEndereco()
         {
             return $this->endereco;
         }

         /**
          * @param mixed $endereco
          */
         public function setEndereco($endereco)
         {
             $this->endereco = $endereco;
         }

         /**
          * @return mixed
          */
         public function getNumero()
         {
             return $this->numero;
         }

         /**
          * @param mixed $numero
          */
         public function setNumero($numero)
         {
             $this->numero = $numero;
         }

         /**
          * @return mixed
          */
         public function getComplemento()
         {
             return $this->complemento;
         }

         /**
          * @param mixed $complemento
          */
         public function setComplemento($complemento)
         {
             $this->complemento = $complemento;
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

         /**
          * @return mixed
          */
         public function getCidade()
         {
             return $this->cidade;
         }

         /**
          * @param mixed $cidade
          */
         public function setCidade($cidade)
         {
             $this->cidade = $cidade;
         }

         /**
          * @return mixed
          */
         public function getFoto()
         {
             return $this->foto;
         }

         /**
          * @param mixed $foto
          */
         public function setFoto($foto)
         {
             $this->foto = $foto;
         }

         /**
          * @return mixed
          */
         public function getStatus()
         {
             return $this->status;
         }

         /**
          * @param mixed $status
          */
         public function setStatus($status)
         {
             $this->status = $status;
         }

         /**
          * @return mixed
          */
         public function getUf()
         {
             return $this->uf;
         }

         /**
          * @param mixed $uf
          */
         public function setUf($uf)
         {
             $this->uf = $uf;
         }


         public function setIdUsuario($idUsuario)
         {
             $this->idUsuario = $idUsuario;
         }

         /**
          * @return mixed
          */
         public function getDepartamento()
         {
             return $this->departamento;
         }

         /**
          * @param mixed $departamento
          */
        
        
        
        
        
    }
?>