<?php

/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 27/05/2016
 * Time: 21:47
 */

require_once('../Ent/Usuario.php');
require_once('../Dao/UsuarioDao.php');
$objUsuarioEnt =new Usuario();
$objUsuarioNeg = new UsuarioNeg();

if(isset($_POST['nome']))
    $objUsuarioEnt->setNome($_POST['nome']);

if(isset($_POST['nome']))
    $objUsuarioEnt->setCpf($_POST['cpf']);

if(isset($_POST['data_nascimento']))
    $objUsuarioEnt->setDataNasc($_POST['data_nascimento']);

if(isset($_POST['telefone']))
    $objUsuarioEnt->setTelefone($_POST['telefone']);

if(isset($_POST['celular']))
    $objUsuarioEnt->setCelular($_POST['celular']);

if(isset($_POST['email']))
    $objUsuarioEnt->setEmail($_POST['email']);
if(isset($_POST['cep']))
    $objUsuarioEnt->setCep($_POST['cep']);

if(isset($_POST['endereco']))
    $objUsuarioEnt->setEndereco($_POST['endereco']);

if(isset($_POST['numero']))
    $objUsuarioEnt->setNumero($_POST['numero']);

if(isset($_POST['complemento']))
    $objUsuarioEnt->setComplemento($_POST['complemento']);

if(isset($_POST['bairro']))
    $objUsuarioEnt->setBairo($_POST['bairro']);

if(isset($_POST['cidade']))
    $objUsuarioEnt->setCidade($_POST['cidade']);
if(isset($_POST['uf']))
    $objUsuarioEnt->setUf($_POST['uf']);

if(isset($_POST['login']))
    $objUsuarioEnt->setLogin($_POST['login']);

if(isset($_POST['senha']))
    $objUsuarioEnt->setSenha($_POST['senha']);

if(isset($_POST['status']))
    $objUsuarioEnt->setStatus($_POST['status']);

if(isset($_POST['codigo']))
    $objUsuarioEnt->setIdUsuario($_POST['codigo']);

//cadastro de  novos usuarios

if(isset($_POST['txtNome']))
    $objUsuarioEnt->setNome($_POST['txtNome']);

if(isset($_POST['txtEmail']))
    $objUsuarioEnt->setEmail($_POST['txtEmail']);

if(isset($_POST['txtTelefone']))
    $objUsuarioEnt->setTelefone($_POST['txtTelefone']);

if(isset($_POST['txtSenha']))
    $objUsuarioEnt->setIdUsuario($_POST['txtSenha']);


if (isset($_POST['action'])){
    switch ($_POST['action']) {

        case 'pesquisarUsuario':
            $objUsuarioEnt = $objUsuarioNeg->Obter($_POST['pesq']);
            $json = json_encode($objUsuarioEnt);
            echo $json;
            break;

        case 'salvarUsuario':

            $teste = $objUsuarioNeg->Salvar($objUsuarioEnt);
            
            echo $teste;
            break;
        
       case 'salvarMenu':
            $teste = $objUsuarioNeg->SalvarMenu($_POST['menu'],$_POST['subMenu']);
            echo $teste;
            break;

//        case 'editarUsuario':
//            $teste= $objUsuarioNeg->Atualizar($objUsuarioEnt);
//            echo $teste;
//            break;


        case 'editarUsuario':
            $teste= $objUsuarioNeg->Atualizar(

                $_POST['nome'],
                $_POST['cpf'],
                $_POST['data_nascimento'],
                $_POST['telefone'],
                $_POST['celular'],
                $_POST['email'],
                $_POST['cep'],
                $_POST['endereco'],
                $_POST['numero'],
                $_POST['complemento'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['uf'],
                $_POST['login'],
                $_POST['senha'],
                $_POST['status']

            );
            echo $teste;
            break;

        case 'excluir':
            $teste=$objUsuarioNeg->Excluir($_POST['id_usuario']);
            echo $teste;
            break;

        case 'carregaDep':
            $usuarios = $objUsuarioNeg->CarregarComboBox();
            $json = json_encode($usuarios);
            echo $json;
            break;

        case 'Login':
            $teste = $objUsuarioNeg->Login($_POST['login'],$_POST['senha']);
            echo $teste;
        break;
//        case 'subMenu':
//            $objUsuarioNeg->subMenu() ;
//            break;

    
    
//        case 'salvarMenu':
//            $objUsuarioNeg->salvarMenu($_SESSION['idOrganizacao'],);
//            break;


        case 'Gravar':

            $teste = $objUsuarioNeg->Gravar($objUsuarioEnt,$_POST["txtEstabelecimento"]);
//            print "<script> alert( $_POST[txtEstabelecimento]); </script>";
            echo $teste;
            break;

    }
}



class UsuarioNeg
{
    public function CarregarComboBox(){
        $UsuarioDao = new UsuarioDao();
        return $UsuarioDao->CarregarComboBox();
    }


    public function Obter($pesq){

        $UsuarioDao = new UsuarioDao();
        return $UsuarioDao->Obter($pesq);
    }


    public function Salvar(Usuario $objUsuario){
        $UsuarioDao = new UsuarioDao();
        return $UsuarioDao->Salvar($objUsuario);

    }

//    public function Atualizar(Usuario $objUsuario){
//        $UsuarioDao = new UsuarioDao();
//        return $UsuarioDao->Atualizar($objUsuario);
//    }


    public function Atualizar($nome,$cpf,$data_nascimento
            ,$telefone,$celular, $email, $cep, $endereco, 
            $numero,$complemento,$bairro,$cidade,$uf,$login
            ,$senha,$status){
        $UsuarioDao = new UsuarioDao();
        return $UsuarioDao->Atualizar(
            $nome,
            $cpf,
            $data_nascimento,
            $telefone,
            $celular,
            $email,
            $cep,
            $endereco,
            $numero,
            $complemento,
            $bairro,
            $cidade,
            $uf,
            $login,
            $senha,
            $status);
    }

    public function Excluir($id){
        $UsuarioDao = new UsuarioDao();
        return $UsuarioDao->Excluir($id);
    }

//    public function Excluir($valor){
//        $UsuarioDao = new UsuarioDao();
//        return $UsuarioDao->Excluir($valor);
//    }


//    public function SalvarMenu(){
//        $UsuarioDao = new UsuarioDao();
//        return $UsuarioDao->SalvarMenu();
//
//    }
//
//    public function subMenu(){
//        $UsuarioDao = new UsuarioDao();
//        $UsuarioDao->subMenu();
//    }



    public function Login($login,$senha){
        $UsuarioDao = new UsuarioDao();
        return $UsuarioDao->Login($login,$senha);

    }


    public function SalvarMenu($menu,$subMenu){
        $UsuarioDao = new UsuarioDao();
        return  $UsuarioDao->SalvarMenu($menu,$subMenu);
    }
//
//
    public function Gravar(Usuario $objUsuario, $estabelecimento){
        $UsuarioDao = new UsuarioDao();
        return $UsuarioDao->Gravar($objUsuario, $estabelecimento);

    }

}
