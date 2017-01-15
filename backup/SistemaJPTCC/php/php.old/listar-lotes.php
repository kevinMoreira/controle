<?php

include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'listarLoteProduto':
            listarLoteProduto();
            break;
    }
}

function listarLoteProduto(){

    session_start();
    $conexao = AbreBancoJP();

    $pesq = '';

    if(isset($_POST['pesq']))
        $pesq = $_POST['pesq']; 

    $sql = "SELECT l.idLote, p.nome, c.nomeCategoria, l.valorCompra, l.qtde, l.validade, f.nome FROM loteprodutos l
    INNER JOIN produto p on p.idProduto=l.idProduto
    LEFT JOIN categoria c on c.idCategoria=p.idCategoria
    LEFT JOIN fornecedor f on f.idFornecedor = l.idFornecedor
    WHERE (p.nome like '%$pesq%' or l.idLote like '%$pesq%' or c.nomeCategoria like '%$pesq%') 
    and l.status=1 and l.idOrganizacao=". $_SESSION['idOrganizacao'] ." 
    and p.status=1 and p.idOrganizacao=". $_SESSION['idOrganizacao'] ." 
    and c.status=1 and c.idOrganizacao=". $_SESSION['idOrganizacao'] ."
    and f.status=1 and f.idOrganizacao=". $_SESSION['idOrganizacao'] ." order by l.validade";//<--- incluir campo de validacao

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
            'valorCompra' => $row['3'], 
            'qtde' => $row['4'],
            'validade' => $row['5'],
            'nomeFornecedor' => $row['6'],
        );    
    }

    echo json_encode($json);
    mysql_close($conexao);
}