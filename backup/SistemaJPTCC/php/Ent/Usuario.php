<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'Pessoa.php';

class Usuario extends Pessoa{
            public $login;
            public $senha;
            public $permicao;
            public $idDepartamento;
            
            public $departamento;


    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

            function _constuct($login,$senha){
                $this-> login=$login;
                $this->senha= $senha;
            } 
            
            function getLogin() {
                return $this->login;
            }

            function getSenha() {
                return $this->senha;
            }

            function getPermicao() {
                return $this->permicao;
            }

            function setLogin($login) {
                $this->login = $login;
            }

            function setSenha($senha) {
                $this->senha = $senha;
            }

            function setPermicao($permicao) {
                $this->permicao = $permicao;
            }

        /**
         * @return mixed
         */
        public function getIdDepartamento()
        {
            return $this->idDepartamento;
        }

        /**
         * @param mixed $idDepartamento
         */
        public function setIdDepartamento($idDepartamento)
        {
            $this->idDepartamento = $idDepartamento;
        }

        /**
         * @return mixed
         */
        public function getIdUsuario()
        {
            return $this->idUsuario;
        }

        /**
         * @param mixed $idUsuario
         */
     

            

    }
    
?>