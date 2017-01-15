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

    $sql="INSERT INTO fornecedor VALUES 
    ('','$_SESSION[idOrganizacao]','$_POST[nome]','$_POST[cnpj]','$_POST[telefone]','$_POST[email]','$_POST[cep]','$_POST[endereco]',
        '$_POST[numero]','$_POST[complemento]','$_POST[bairro]','$_POST[cidade]','$_POST[uf]',1)";

    mysql_query($sql, $conexao);
    mysql_close($conexao);
}

function pesquisarFornecedor(){

    session_start();
    $conexao= AbreBancoJP();

        $sql="SELECT * from fornecedor
        where (nome='$_POST[pesq]' OR telefone='$_POST[pesq]' OR cnpj='$_POST[pesq]' or idfornecedor='$_POST[pesq]') and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];

    $sql=mysql_query($sql, $conexao);

     if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($sql)){

        $json[]= array(
            'id_fornecedor' => $row['0'],
            'nome' => $row['2'],
            'cnpj' => $row['3'],
            'telefone' => $row['4'],
            'email' => $row['5'],
            'cep' => $row['6'],
            'endereco' => $row['7'],
            'numero' => $row['8'],
            'complemento' => $row['9'],
            'bairro' => $row['10'],
            'cidade' => $row['11'],
            'uf' => $row['12'],
            'status' => $row['13'],         
         );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function excluir(){//modificar nao excluir fisicamente. Utilizar campo del
    
    $conexao = AbreBancoJP();

    $sql = "UPDATE fornecedor set status=0 where idFornecedor = '$_POST[id_fornecedor]' and status=1 and idOrganizacao". $_SESSION['idOrganizacao'];

    mysql_query($sql,$conexao);
    mysql_close($conexao);
}


//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function editarFornecedor(){

    session_start();
    $conexao=AbreBancoJP();

    $sql="UPDATE fornecedor set nome='$_POST[nome]', cnpj='$_POST[cnpj]',
    telefone='$_POST[telefone]', email='$_POST[email]', cep='$_POST[cep]', 
    endereco='$_POST[endereco]',numero='$_POST[numero]', complemento='$_POST[complemento]', 
    bairro='$_POST[bairro]', cidade='$_POST[cidade]',estado='$_POST[uf]' 
    WHERE idFornecedor = $_POST[id_fornecedor] and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];

    mysql_query($sql, $conexao);
    mysql_close($conexao);
}