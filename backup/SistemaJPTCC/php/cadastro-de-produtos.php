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

    $sql = "call USP_MANTER_CATEGORIAS(null, ".$_SESSION['idOrganizacao'].", null,null,null,3);";

    $query = mysql_query($sql, $conexao);

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

    /*session_start();
    $conexao=AbreBancoJP();

    $sql="INSERT INTO produto VALUES ($_POST[codigo], $_SESSION[idOrganizacao], $_POST[categoria], '$_POST[nome]', $_POST[valorVenda], 1)";

    mysql_query($sql, $conexao);
    mysql_close($conexao);*/

    session_start();

    $conexao =  new MySQL();

    $sql = "set @NOME_ = $_POST[nome];
    set @ID_ORGANIZACAO = '$_SESSION[idOrganizacao]';
    set @ID_CATEGORIA = $_POST[categoria];
    set @STATUS_ =1;
    set @ID_PRODUTO =NULL;
    set @VALOR_VENDA = $_POST[valorVenda];
    set @CODIGO_BARRAS = $_POST[codigo];
    set @PESQUISA = NULL;
    set @ID_PARAMETRO_CONSULTA = 0;
    call USP_MANTER_PRODUTOS(@NOME_, @ID_ORGANIZACAO, @ID_CATEGORIA,@STATUS_,@ID_PRODUTO,@VALOR_VENDA,@CODIGO_BARRAS,@PESQUISA,@ID_PARAMETRO_CONSULTA);";

    $conexao->execSP($sql);
}

function pesquisarProduto(){

    session_start();

    $conexao= AbreBancoJP();

    $sql = "call USP_MANTER_PRODUTOS(null, ".$_SESSION['idOrganizacao'].", null,null,'".$_POST['pesq']."',null,null,'".$_POST['pesq']."',3);";

    $sql=mysql_query($sql, $conexao);
    while($resultado=mysql_fetch_assoc($sql)){
        $json[]= array(
            'id_produto' => $resultado['ID_PRODUTO'],
            'nome' => $resultado['NOME'],
            'valorVenda' => $resultado['VALOR_VENDA'],
            'idCategoria' => $resultado['ID_CATEGORIA'],
            'nomeCategoria' => $resultado['NOME_CATEGORIA'],

            );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function excluir(){//modificar nao excluir fisicamente. Utilizar campo del
    /*session_start();
    $conexao = AbreBancoJP();*/

    session_start();

    $conexao =  new MySQL();

    $sql = "set @NOME_ = NULL;
    set @ID_ORGANIZACAO = '$_SESSION[idOrganizacao]';
    set @ID_CATEGORIA = NULL;
    set @STATUS_ =NULL;
    set @ID_PRODUTO = $_POST[id_produto];
    set @VALOR_VENDA =NULL;
    set @CODIGO_BARRAS =NULL;
    set @PESQUISA = NULL;
    set @ID_PARAMETRO_CONSULTA = 2;
    call USP_MANTER_PRODUTOS(@NOME_, @ID_ORGANIZACAO, @ID_CATEGORIA,@STATUS_,@ID_PRODUTO,@VALOR_VENDA,@CODIGO_BARRAS,@PESQUISA,@ID_PARAMETRO_CONSULTA);";

    $conexao->execSP($sql);

    //$sql = "UPDATE produto set status = 0 where idProduto = $_POST[id_produto] and idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";

    /*$sql=mysql_query($sql,$conexao);
    mysql_close($conexao);*/
}

//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function editarProduto(){

    /*session_start();
    $conexao=AbreBancoJP();

    $sql="UPDATE produto set nome='$_POST[nome]', valorVenda='$_POST[valorVenda]', idCategoria='$_POST[categoria]'
    WHERE idProduto = $_POST[id_produto] and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];

    mysql_query($sql, $conexao);
    mysql_close($conexao);*/

    session_start();

    $conexao =  new MySQL();

    $sql = "set @NOME_ = $_POST[nome];
    set @ID_ORGANIZACAO = '$_SESSION[idOrganizacao]';
    set @ID_CATEGORIA = $_POST[categoria];
    set @STATUS_ =1;
    set @ID_PRODUTO = $_POST[id_produto];
    set @VALOR_VENDA =$_POST[valorVenda];
    set @CODIGO_BARRAS =NULL;
    set @PESQUISA = NULL;
    set @ID_PARAMETRO_CONSULTA = 1;
    call USP_MANTER_PRODUTOS(@NOME_, @ID_ORGANIZACAO, @ID_CATEGORIA,@STATUS_,@ID_PRODUTO,@VALOR_VENDA,@CODIGO_BARRAS,@PESQUISA,@ID_PARAMETRO_CONSULTA);";

    $conexao->execSP($sql);
}