<?php

/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 30/05/2016
 * Time: 22:35
 */


include 'sistemaJP.php';

date_default_timezone_set('America/Sao_Paulo'); //fuso horario

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'busca':
            BuscarProduto();
            break;

        case 'criaVenda':
            CriarVenda();
            break;

        case 'baixaEstoque':
            EfetuarBaixaEstoque();
            break;
    }
}


class VendaNeg
{
    function BuscarProduto(){
        
    }

    function CriarVenda(){

    }

    function EfetuarBaixaEstoque(){

    }
    
    
    
}