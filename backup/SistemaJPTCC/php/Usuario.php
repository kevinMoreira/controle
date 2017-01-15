<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    class usuario extends Pessoa{
            private $login;
            private $senha;
            private $permicao;
            
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

            
            
           function Logar(){
             
         }   
        
    }
    
?>