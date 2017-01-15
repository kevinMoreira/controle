<?php

include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'salvarCliente':
            salvarCliente();
            break;

        case 'pesquisarCliente':
            pesquisarCliente();
            break;

        case 'excluir':
            excluir();
            break;

        case 'editarCliente':
            editarCliente();
            break;
    }
}

//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function salvarCliente(){

    session_start();
    $conexao=AbreBancoJP();

    $sql = "call USP_MANTER_CLIENTES
            (
                '$_POST[nome]',
                $_SESSION[idOrganizacao],
                1,
                '',
                '$_POST[cpf]',
                '$_POST[data_nascimento]',
                '$_POST[telefone]',
                '$_POST[celular]',
                '$_POST[email]',
                '$_POST[cep]',
                '$_POST[numero]',
                '$_POST[complemento]',    
                '',
                0,
                $_SESSION[codUsuario],
                '$_POST[uf]',
                '$_POST[cidade]',
                '$_POST[bairro]',
                '$_POST[endereco]'
            )";

    mysql_query($sql, $conexao);
    mysql_close($conexao);
}

function pesquisarCliente(){

    session_start();
    $conexao= AbreBancoJP();

    // $sql="SELECT * from cliente where (nome='$_POST[pesq]' OR telefone='$_POST[pesq]' OR cpf='$_POST[pesq]') 
    // and status = 1 and idOrganizacao=". $_SESSION['idOrganizacao'];

    $sql = "call USP_MANTER_CLIENTES
            (
                '',
                $_SESSION[idOrganizacao],
                '',
                '$_POST[pesq]',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                3,
                '',
                '',
                '',
                '',
                ''
            )";

    $result=mysql_query($sql, $conexao);

     if(mysql_num_rows($result) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($result)){
        $json[]= array(
            'id_cliente' => $row['0'],
            'nome' => $row['1'],
            'cpf' => $row['2'],
            'data_nascimento' => $row['3'],
            'telefone' => $row['4'],
            'celular' => $row['5'],
            'email' => $row['6'],
            'cep' => $row['7'],
            'endereco' => $row['8'],
            'numero' => $row['9'],
            'complemento' => $row['10'],
            'bairro' => $row['11'],
            'cidade' => $row['12'],
            'uf' => $row['13'],
            'status_' => $row['14'],
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function excluir(){//modificar nao excluir fisicamente. Utilizar campo del
    
    session_start();
    $conexao = AbreBancoJP();

    //$sql = "UPDATE cliente set status = 0 where idCliente = $_POST[id_cliente] and idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";

     $sql = "call USP_MANTER_CLIENTES
            (
                '',
                $_SESSION[idOrganizacao],
                1,
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                $_POST[id_cliente],
                2,
                $_SESSION[codUsuario],
                '',
                '',
                '',
                ''
            )";

    mysql_query($sql,$conexao); 
    mysql_close($conexao);
}

//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function editarCliente(){

    session_start();
    $conexao=AbreBancoJP();

    // $sql="UPDATE cliente set nome='$_POST[nome]', cpf='$_POST[cpf]', data_nascimento='$_POST[data_nascimento]', telefone='$_POST[telefone]',
    // celular='$_POST[celular]', email='$_POST[email]', cep='$_POST[cep]', endereco='$_POST[endereco]',numero='$_POST[numero]', 
    // complemento='$_POST[complemento]', bairro='$_POST[bairro]', cidade='$_POST[cidade]',uf='$_POST[uf]', status='$_POST[status]' 
    // WHERE idCliente = $_POST[id_cliente] and idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";

     $sql = "call USP_MANTER_CLIENTES
            (
                '$_POST[nome]',
                $_SESSION[idOrganizacao],
                $_POST[status],
                NULL,
                '$_POST[cpf]',
                '$_POST[data_nascimento]',
                '$_POST[telefone]',
                '$_POST[celular]',
                '$_POST[email]',
                '$_POST[cep]',
                '$_POST[numero]',
                '$_POST[complemento]',
                $_POST[id_cliente],
                1,
                $_SESSION[codUsuario],
                '$_POST[uf]',
                '$_POST[cidade]',
                '$_POST[bairro]',
                '$_POST[endereco]'
            )";
    mysql_query($sql, $conexao);
    mysql_close($conexao);
}