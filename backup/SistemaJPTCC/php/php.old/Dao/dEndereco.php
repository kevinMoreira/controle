<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 14/07/2015
 * Time: 23:50
 */
require_once('../MySQL.php');
require_once('../Ent/eEndereco.php');

class dEndereco {

    //Retorna endereço cadstrado na base
    public function Obter($cep){
        $conexao= new MySQL();
        $objEndereco= new eEndereco();
        //Seleciona endereço na base
        $sql="set @CEP = '$cep'; call USP_SEL_ENDERECO(@CEP);";
        $retorno = $conexao->execSP($sql);

        //Se endereço não existir realiza uma busca no web service
        if($retorno != null)
        {
            $objEndereco->setLogradouro($retorno["Logradouro"]);
            $objEndereco->setBairro($retorno["Bairro"]);
            $objEndereco->setCidade($retorno["Cidade"]);
            $objEndereco->setEstado($retorno["Estado"]);
            $objEndereco->setCep($retorno["Cep"]);
        }else{
            $objEndereco = $this->ConsultarWebServiceEndereco($cep);
            $this->Salvar($objEndereco);
        }
        return $objEndereco;
    }

    //Retorna endereço consultado no web service apimon
    private function ConsultarWebServiceEndereco($cep){
        $objEndereco = new eEndereco();
        $jsonEndereco = file_get_contents('http://api.postmon.com.br/v1/cep/'.$cep);
        $objEndereco->setLogradouro(utf8_decode($jsonEndereco["Logradouro"]));
        $objEndereco->setBairro(utf8_decode($jsonEndereco["Bairro"]));
        $objEndereco->setCidade(utf8_decode($jsonEndereco["Cidade"]));
        $objEndereco->setEstado(utf8_decode($jsonEndereco["Estado"]));
        $objEndereco->setCep(utf8_decode($jsonEndereco["Cep"]));

        return $objEndereco;
    }

    //Salva endereco na base
    private function Salvar(eEndereco $endereco){
        $conexao= new MySQL();
        $objEndereco= new eEndereco();
        //Seleciona endereço na base
        $sql="set @CEP = '$endereco->getCep()';
        set @LOGRADOURO = '$endereco->getLogradouro()';
        set @BAIRRO = '$endereco->getBairro()';
        set @CIDADE = '$endereco->getCidade()';
        set @ESTADO = '$endereco->getEstado()';
        call USP_INS_ENDERECO(@CEP, @LOGRADOURO, @BAIRRO, @CIDADE, @ESTADO);";
        $retorno = $conexao->execSP($sql);
    }

    //Atualiza endereco na base
    private function Atualizar(eEndereco $endereco){
        $conexao= new MySQL();
        $objEndereco= new eEndereco();
        //Seleciona endereço na base
        $sql="set @CEP = '$endereco->getCep()';
        set @LOGRADOURO = '$endereco->getLogradouro()';
        set @BAIRRO = '$cep';
        set @CIDADE = '$cep';
        set @ESTADO = '$cep';
        call USP_UPD_ENDERECO(@CEP, @LOGRADOURO, @BAIRRO, @CIDADE, @ESTADO);";
        $retorno = $conexao->execSP($sql);
    }
} 