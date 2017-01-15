<?php
/**
 * Created Keivn Rangel.
 * User: Kevin_000
 * Date: 14/07/2015
 * Time: 23:50
 */

require_once('../Dao/FornecedorDao.php');
require_once('../Ent/Fornecedor.php');

$objFornecedorNeg = new FornecedorNeg();
$objFornecedorEnt = new Fornecedor();

if(isset($_POST['nome']))
    $objFornecedorEnt->setNome($_POST['nome']);

if(isset($_POST['cnpj']))
    $objFornecedorEnt->setCnpj($_POST['cnpj']);

if(isset($_POST['telefone']))
    $objFornecedorEnt->setTelefone($_POST['telefone']);

if(isset($_POST['email']))
    $objFornecedorEnt->setEmail($_POST['email']);

if(isset($_POST['cep']))
    $objFornecedorEnt->setCep($_POST['cep']);

if(isset($_POST['endereco']))
    $objFornecedorEnt->setEndereco($_POST['endereco']);

if(isset($_POST['numero']))
    $objFornecedorEnt->setNumero($_POST['numero']);

 if(isset($_POST['complemento']))   
    $objFornecedorEnt->setComplemento($_POST['complemento']);

if(isset($_POST['bairro']))
    $objFornecedorEnt->setBairro($_POST['bairro']);

if(isset($_POST['cidade']))
    $objFornecedorEnt->setCidade($_POST['cidade']);

if(isset($_POST['uf']))
    $objFornecedorEnt->setUf($_POST['uf']);

if(isset($_POST['fornecedorId']))
    $objFornecedorEnt->setFornecedorId($_POST['fornecedorId']);

if(isset($_POST['status']))
    $objFornecedorEnt->setStatus($_POST['status']);

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'pesquisarFornecedor':

            $objFornecedorEnt = $objFornecedorNeg->Obter($_POST['pesq']);
            $json = json_encode( $objFornecedorEnt );
            echo $json;

            break;
            
         case 'salvarFornecedor':

            $teste = $objFornecedorNeg->Salvar($objFornecedorEnt);
            echo $teste;

            break;
            
         case 'excluirFornecedor':
           $objFornecedorNeg->Excluir($objFornecedorEnt);
            break;
            
         case 'editarFornecedor':
           $teste= $objFornecedorNeg->Atualizar($objFornecedorEnt);
           echo $teste;
            break;
    }       
}


 class FornecedorNeg {
     public function Obter($pesq){
        $objFornecedorDao = new FornecedorDao();
        return $objFornecedorDao->Obter($pesq);
     }
     
     public function Salvar( $objFornecedor){
        $FornecedorDao = new FornecedorDao();
        return $FornecedorDao->Salvar($objFornecedor);
     }
     
     public function Excluir($objFornecedor){
        $FornecedorDao = new FornecedorDao();
        $FornecedorDao->Excluir($objFornecedor);
     }
     
     public function Atualizar($objFornecedor){
        $FornecedorDao = new FornecedorDao();
        return $FornecedorDao->Atualizar($objFornecedor);
     }
}