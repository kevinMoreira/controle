<?php

include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'salvarFornecedor':
            salvarFornecedor();
            break;

        case 'pesquisarFornecedor':
            pesquisarFornecedor();
            break;

        case 'excluir':
            excluir();
            break;

        case 'editarFornecedor':
            editarFornecedor();
            break;
    }
}

//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function salvarFornecedor(){

    session_start();
    $conexao=AbreBancoJP();

     $sql = "call USP_MANTER_FORNECEDORES
            (
                $_SESSION[idOrganizacao],
                NULL,
                1,
                '',
                '$_POST[nome]',
                '$_POST[cnpj]',
                '$_POST[telefone]',
                '$_POST[email]',
                '$_POST[cep]',
                '$_POST[endereco]',
                '$_POST[numero]',
                '$_POST[complemento]',
                '$_POST[bairro]',
                '$_POST[cidade]',
                '$_POST[uf]',
                0,
                $_SESSION[codUsuario]
            )";
    mysql_query($sql, $conexao);
    mysql_close($conexao);
}

function pesquisarFornecedor(){

    session_start();
    $conexao= AbreBancoJP();

    $sql = "call USP_MANTER_FORNECEDORES
    (
        $_SESSION[idOrganizacao],
        NULL,
        NULL,
        '$_POST[pesq]',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        3,
        NULL
    )";

    $sql=mysql_query($sql, $conexao);

     if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($sql)){

        $json[]= array(
            'id_fornecedor' => $row['0'],
            'nome' => $row['1'],
            'cnpj' => $row['2'],
            'telefone' => $row['3'],
            'email' => $row['4'],
            'cep' => $row['5'],
            'endereco' => $row['6'],
            'numero' => $row['7'],
            'complemento' => $row['8'],
            'bairro' => $row['9'],
            'cidade' => $row['10'],
            'uf' => $row['11'],
            'status' => $row['12'],         
         );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function excluir(){//modificar nao excluir fisicamente. Utilizar campo del
    
    $conexao = AbreBancoJP();

    $sql = "call USP_MANTER_FORNECEDORES
    (
        $_SESSION[idOrganizacao],
        '$_POST[id_fornecedor]',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        2,
        $_SESSION[codUsuario]
    )";


    mysql_query($sql,$conexao);
    mysql_close($conexao);
}


//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function editarFornecedor(){

    session_start();
    $conexao=AbreBancoJP();

    $sql = "call USP_MANTER_FORNECEDORES
            (
                $_SESSION[idOrganizacao],
                $_POST[id_fornecedor],
                1,
                '',
                '$_POST[nome]',
                '$_POST[cnpj]',
                '$_POST[telefone]',
                '$_POST[email]',
                '$_POST[cep]',
                '$_POST[endereco]',
                '$_POST[numero]',
                '$_POST[complemento]',
                '$_POST[bairro]',
                '$_POST[cidade]',
                '$_POST[uf]',
                1,
                $_SESSION[codUsuario]
            )";
    mysql_query($sql, $conexao);
    mysql_close($conexao);
}