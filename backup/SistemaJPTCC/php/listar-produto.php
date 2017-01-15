<?php

include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'listarProduto':
            listarProduto();
            break;
    }
}

function listarProduto(){

    session_start();
    $conexao = AbreBancoJP();

    $pesq = '';

    if(isset($_POST['pesq']))
        $pesq = $_POST['pesq']; 

    $sql = "SELECT p.idProduto, p.nome, c.nomeCategoria FROM produto p
    INNER JOIN categoria c on c.idCategoria=p.idCategoria
    WHERE (p.nome like '%$pesq%' or p.idProduto like '%$pesq%' or c.nomeCategoria like '%$pesq%') 
    and p.status=1 and p.idOrganizacao=". $_SESSION['idOrganizacao'] ."
    and c.status=1 and c.idOrganizacao=". $_SESSION['idOrganizacao'] ."
    GROUP BY p.idProduto order by p.nome";
    
    $sql = mysql_query($sql, $conexao);

    if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row = mysql_fetch_row($sql)){

        $json[] = array(
            'codigo' => $row['0'],
            'nome' => $row['1'], 
            'nomeCategoria' => $row['2'],
        );    
    }

    echo json_encode($json);
    mysql_close($conexao);
}