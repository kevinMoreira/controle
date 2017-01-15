<?php
require_once('../Ent/Categoria.php');
require_once('../Dao/CategoriaDao.php');
$objCategoria= new Categoria();
$objCategoriaNeg = new CategoriaNeg();


if(isset($_POST['nome']))
    $objCategoria->setNome($_POST['nome']);

if(isset($_POST['idCategoria']))
    $objCategoria->setIdCategoria($_POST['idCategoria']);



//chamando as ações

if (isset($_POST['action'])){
    switch ($_POST['action']) {

        case 'pesquisarCategoria':
            $objCategoriaEnt = $objCategoriaNeg->Obter($_POST['pesq']);
            $json = json_encode( $objCategoriaEnt );
            echo $json;
            break;

        case 'salvarCategoria':
            $teste = $objCategoriaNeg->Salvar($objCategoria);
            echo $teste;
            break;

        case 'editarCategoria':
            $objCategoriaNeg->Atualizar($objCategoria);
            break;


        case 'excluir':
            $objCategoriaNeg->Excluir($objCategoria);
            break;

    }
}

class CategoriaNeg {

    public function Obter($pesquisa){
         $CategoriaDao = new CategoriaDao();
         return $CategoriaDao->Obter($pesquisa);
    }
        
     
     public function Salvar(Categoria $objCategoria){
         $CategoriaDao = new CategoriaDao();
         return  $CategoriaDao->Salvar($objCategoria);
        

    }
     
     public function Excluir(Categoria $objCategoria){

         $CategoriaDao = new CategoriaDao();
       
         return $CategoriaDao->Excluir($objCategoria);
       
    }
     
     public function Atualizar( $objCategoria){

         $CategoriaDao = new CategoriaDao();

         return $CategoriaDao->Atualizar($objCategoria);
        
    }
    
    
}