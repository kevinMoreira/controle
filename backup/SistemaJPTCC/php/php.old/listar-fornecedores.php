<?php

include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'listarFornecedor':
            listarFornecedor();
            break;
    }
}

function listarFornecedor(){


    session_start();
    $conexao = AbreBancoJP();

    $pesq = '';

    if(isset($_POST['pesq']))
        $pesq = $_POST['pesq']; 

    $sql = "SELECT * FROM fornecedor 
    where (telefone like '%$pesq%' or nome like '%$pesq%' or cnpj like '%$pesq%') and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'] ." order by nome";
    $sql = mysql_query($sql, $conexao);

    if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row = mysql_fetch_row($sql)){

        $json[] = array(
            'codigo' => $row['0'],
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
            'estado' => $row['12'],
            'status' => $row['13'],
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}