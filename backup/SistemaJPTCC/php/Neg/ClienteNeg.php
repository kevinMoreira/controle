<?php

/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 28/05/2016
 * Time: 21:55
 */
require_once('../Dao/ClienteDao.php');
require_once('../Ent/Cliente.php');
$objClienteEnt = new Cliente();
$objClienteNeg = new ClienteNeg();

if(isset($_POST['nome']))
    $objClienteEnt->setNome($_POST['nome']);

if(isset($_POST['nome']))
    $objClienteEnt->setCpf($_POST['cpf']);

if(isset($_POST['data_nascimento']))
    $objClienteEnt->setDataNasc($_POST['data_nascimento']);

if(isset($_POST['telefone']))
    $objClienteEnt->setTelefone($_POST['telefone']);

if(isset($_POST['celular']))
    $objClienteEnt->setCelular($_POST['celular']);

if(isset($_POST['email']))
    $objClienteEnt->setEmail($_POST['email']);
if(isset($_POST['cep']))
    $objClienteEnt->setCep($_POST['cep']);

if(isset($_POST['endereco']))
    $objClienteEnt->setEndereco($_POST['endereco']);

if(isset($_POST['numero']))
    $objClienteEnt->setNumero($_POST['numero']);

if(isset($_POST['complemento']))
    $objClienteEnt->setComplemento($_POST['complemento']);

if(isset($_POST['bairro']))
    $objClienteEnt->setBairo($_POST['bairro']);

if(isset($_POST['cidade']))
    $objClienteEnt->setCidade($_POST['cidade']);
if(isset($_POST['uf']))
    $objClienteEnt->setUf($_POST['uf']);



if(isset($_POST['status']))
    $objClienteEnt->setStatus($_POST['status']);

if(isset($_POST['codigo']))
    $objClienteEnt->setIdCliente($_POST['codigo']);

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'pesquisarCliente':
            $objClienteEnt = $objClienteNeg->Obter($_POST['pesq']);
            $json = json_encode($objClienteEnt);
            echo $json;
            break;

        case 'salvarCliente':
            $teste = $objClienteNeg->Salvar($objClienteEnt);
            echo $teste;
            break;

//        case 'editarCliente':
//            $teste = $objClienteNeg->Atualizar($objClienteEnt);
//            echo $teste;
//            break;


//        case 'excluir':
//            $teste = $objClienteNeg->Excluir($objClienteEnt);
//            echo $teste;
//            break;

        case 'excluir':
            $teste = $objClienteNeg->Excluir($_POST['id_cliente']);
            echo $teste;
            break;

        case 'editarCliente':
            $teste = $objClienteNeg->Atualizar($_POST['id_cliente'], $_POST['nome'], ($_POST['cpf']),
                $_POST['data_nascimento'], $_POST['telefone'], $_POST['celular'], $_POST['email'], 
                $_POST['cep'], $_POST['endereco'], $_POST['numero'],$_POST['complemento'], 
                $_POST['bairro'],$_POST['cidade'], $_POST['uf'], $_POST['status']);
            echo $teste;
            break;


    }
}


class ClienteNeg
{
    public function Obter($pesq){

        $ClienteDao = new ClienteDAO();
        return $ClienteDao->Obter($pesq);
    }


    public function Salvar(Cliente $objClienteEnt){
        $ClienteDao = new ClienteDAO();
        return $ClienteDao->Salvar($objClienteEnt);

    }

//    public function Atualizar(Cliente $objClienteEnt){
//        $ClienteDao = new ClienteDAO();
//        return $ClienteDao->Atualizar($objClienteEnt);
//    }

//    public function Excluir(Cliente $objClienteEnt){
//        $ClienteDao = new ClienteDAO();
//        return $ClienteDao->Excluir($objClienteEnt);
//    }

    public function Excluir($pesq){
        $ClienteDao = new ClienteDAO();
        return $ClienteDao->Excluir($pesq);
    }

    public function Atualizar($id, $nome , $cpf,
                              $data_nascimento, $telefone, $celular, $email,
                              $cep, $endereco, $numero,$complemento,
                              $bairro,$cidade, $uf, $status){
        $ClienteDao = new ClienteDAO();
        return $ClienteDao->Atualizar($id, $nome , $cpf,
            $data_nascimento, $telefone, $celular, $email,
            $cep, $endereco, $numero,$complemento,
            $bairro,$cidade, $uf, $status);
    }

    
}