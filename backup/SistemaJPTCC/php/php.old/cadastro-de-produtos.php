<?php

include 'sistemaJP.php';
require_once('MySQL.php');

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'carregarComboBox':
        carregarComboBox();
        break;

        case 'salvarProduto':
        salvarProduto();
        break;

        case 'pesquisarProduto':
        pesquisarProduto();
        break;

        case 'excluir':
        excluir();
        break;

        case 'editarProduto':
        editarProduto();
        break;
    }
}

function carregarComboBox(){

    session_start();

    $conexao = AbreBancoJP();

    $sql = "call USP_MANTER_CATEGORIAS(
        '', 
        $_SESSION[idOrganizacao], 
        '',
        '',
        '',
        3,
        $_SESSION[codUsuario]
        );";

    $query = mysql_query($sql, $conexao);

    if(mysql_num_rows($query) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }


    while($row=mysql_fetch_row($query)){

        $json[] = array(
            'id_categoria' => $row[0],
            'nome_categoria'=>$row[1]
            );
    }
    echo json_encode($json);
}

//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function salvarProduto(){
    session_start();
    $conexao=AbreBancoJP();

    $sql = "
    call USP_MANTER_PRODUTOS
    (
            '$_POST[nome]', 
            $_SESSION[idOrganizacao], 
            $_POST[categoria],
            1,
            NULL,
            $_POST[valorVenda],
            $_POST[codigo],
            NULL,
            0,
            $_SESSION[codUsuario]
    );";

    mysql_query($sql, $conexao);
    mysql_close($conexao);
}

function pesquisarProduto(){
    session_start();
    $conexao= AbreBancoJP();

    $sql = "call USP_MANTER_PRODUTOS
            (
               NULL, 
                $_SESSION[idOrganizacao], 
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                '$_POST[pesq]',
                3,
                $_SESSION[codUsuario]
            );";

    $sql=mysql_query($sql, $conexao);
    while($resultado=mysql_fetch_row($sql)){
        $json[]= array(
            'id_produto' => $resultado['0'],
            'nome' => $resultado['1'],
            'valorVenda' => $resultado['2'],
            'idCategoria' => $resultado['3'],
            'nomeCategoria' => $resultado['4'],

            );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function excluir(){//modificar nao excluir fisicamente. Utilizar campo del
    session_start();
    $conexao = AbreBancoJP();

    //$sql = "UPDATE produto set status = 0 where idProduto = $_POST[id_produto] and idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";

    $sql = "
    call USP_MANTER_PRODUTOS(
            NULL, 
            $_SESSION[idOrganizacao], 
            NULL,
            NULL,
            $_POST[id_produto],
            NULL,
            NULL,
            NULL,
            2,
            $_SESSION[codUsuario]
    );";
    $sql=mysql_query($sql,$conexao);
    mysql_close($conexao);
}

//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function editarProduto(){

    session_start();
    $conexao=AbreBancoJP();

    // $sql="UPDATE produto set nome='$_POST[nome]', valorVenda='$_POST[valorVenda]', idCategoria='$_POST[categoria]'
    // WHERE idProduto = $_POST[id_produto] and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];

    $sql = "
    call USP_MANTER_PRODUTOS(
             '$_POST[nome]', 
            $_SESSION[idOrganizacao], 
            $_POST[categoria],
            1,
            $_POST[id_produto],
            $_POST[valorVenda],
            NULL,
            NULL,
            1,
            $_SESSION[codUsuario]
    );";
    mysql_query($sql, $conexao);
    mysql_close($conexao);
}