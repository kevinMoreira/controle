<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 14/07/2015
 * Time: 23:50
 */
require_once('../Dao/dEndereco.php');

class nEndereco {
    public function Obter($cep){
        $dEndereco= new dEndereco();
        return $dEndereco->Obter($cep);
    }
}