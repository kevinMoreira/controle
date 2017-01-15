<?php

include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'listarCliente':
            listarCliente();
            break;
    }
}

function listarCliente(){

    session_start();
    $conexao = AbreBancoJP();

    $pesq = '';

    if(isset($_POST['pesq']))
        $pesq = $_POST['pesq']; 

    $sql = "SELECT * FROM cliente 
    where (telefone like '%$pesq%' or nome like '%$pesq%' or cpf like '%$pesq%') and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'] ." order by nome";

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
            'cpf' => $row['3'],
            'data_nascimento' => $row['4'],
            'telefone' => $row['5'],
            'celular' => $row['6'],
            'email' => $row['7'],
            'cep' => $row['8'],
            'endereco' => $row['9'],
            'numero' => $row['10'],
            'complemento' => $row['11'],
            'bairro' => $row['12'],
            'cidade' => $row['13'],
            'estado' => $row['14'],
            'status' => $row['15'],
        );
    
    }

    echo json_encode($json);
    mysql_close($conexao);
}