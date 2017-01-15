<?php
include 'Pessoa.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    class Cliente extends Pessoa{
        public  $idCliente;
        public $idUsuario;

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
        public function setIdUsuario($idUsuario)
        {
            $this->idUsuario = $idUsuario;
        }
        /**
         * @return mixed
         */
        public function getIdCliente()
        {
            return $this->idCliente;
        }

        /**
         * @param mixed $idCliente
         */
        public function setIdCliente($idCliente)
        {
            $this->idCliente = $idCliente;
        }


    }

?>
