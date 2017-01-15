<?php

include 'sistemaJP.php';

date_default_timezone_set('America/Sao_Paulo'); //fuso horario

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'carregarComboBoxProd':
            carregarComboBoxProd();
            break;

        case 'carregarComboBoxCat':
            carregarComboBoxCat();
            break;

        case 'carregarComboBoxForn':
            carregarComboBoxForn();
            break;

        case 'salvarCompraProduto':
            salvarCompraProduto();
            break;

        case 'pesquisarCompraProduto':
            pesquisarCompraProduto();
            break;

        case 'pesquisarProduto':
            pesquisarProduto();
            break;

        case 'excluir':
            excluir();
            break;

        case 'editarCompraProduto':
            editarCompraProduto();
            break;
    }
}

function pesquisarProduto(){

    session_start();
    $conexao = AbreBancoJP();

    $sql = "select p.idproduto, p.nome, c.idCategoria, c.nomeCategoria from produto p
    inner join categoria c on c.idCategoria = p.idCategoria
    where p.idProduto =". $_POST['codigo'] ." 
    and p.status=1 and p.idOrganizacao=". $_SESSION['idOrganizacao'] ." 
    and c.status=1 and c.idOrganizacao=". $_SESSION['idOrganizacao'];
    $sql = mysql_query($sql, $conexao);
    
    while ($row = mysql_fetch_row($sql)) {
        $json[] = array(
            'idProduto' => $row['0'],
            'nome' => $row['1'],
            'idCategoria' => $row['2'],
            'nomeCategoria' => $row['3']
        );
    }
    echo json_encode($json);
    mysql_close($conexao);
}

function carregarComboBoxCat(){

    session_start();
    $conexao = AbreBancoJP();

    $query = 'SELECT * FROM categoria where idOrganizacao='. $_SESSION['idOrganizacao'] .' and status = 1';
    $query = mysql_query($query, $conexao);

    while($row=mysql_fetch_row($query)){

        $json[] = array(
            'id_categoria' => $row['0'],
            'nome_categoria' => $row['2']
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function CarregarComboBoxProd(){

    session_start();
    $conexao = AbreBancoJP();
    $query = 'SELECT idProduto, nome FROM produto where idCategoria ='. $_POST['id_categoria']. ' and idOrganizacao='. $_SESSION['idOrganizacao'] .' and status = 1';
    
    $query = mysql_query($query, $conexao);

    while($row=mysql_fetch_row($query)){

        $json[] = array(
            'id_produto' => $row['0'],
            'nome' => $row['1']
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function carregarComboBoxForn(){

    session_start();
    $conexao = AbreBancoJP();

    $query = "SELECT idFornecedor, nome FROM fornecedor where idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";
    
    $query = mysql_query($query, $conexao);

    while($row=mysql_fetch_row($query)){

        $json[] = array(
            'id_fornecedor' => $row['0'],
            'nome' => $row['1']
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}


//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function salvarCompraProduto(){

    session_start();
    $conexao=AbreBancoJP();

   //Para isso ela precisa estar no fuso horário de são paulo setado no inicio do programa

    $sql="
        INSERT INTO loteprodutos 
        (
            idOrganizacao,
            idProduto,
            idFornecedor,
            valorCompra,
            qtde,
            validade,
            data,
            status,
            CadastroDataHora,
            CadastroUsuarioId
        )
        VALUES 
        (           
            $_SESSION[idOrganizacao], 
            $_POST[id_produto], 
            $_POST[id_fornecedor], 
            $_POST[valorCompra],
            $_POST[qtde], 
            '$_POST[validade]',
            curdate(), 
            1,
            CURRENT_TIMESTAMP(),
            $_SESSION[codUsuario]
        );";

echo $sql;

    $sql = mysql_query($sql, $conexao);
    mysql_close($conexao);
}

function pesquisarCompraProduto(){

    session_start();
    $conexao= AbreBancoJP();

    $sql="SELECT c.nomeCategoria, p.nome, f.nome, l.valorCompra, l.qtde, l.validade, l.idLote from loteprodutos l
    INNER JOIN produto p on p.idProduto = l.idProduto
    INNER JOIN categoria c on c.idCategoria = p.idCategoria
    LEFT JOIN fornecedor f on f.idFornecedor = l.idFornecedor
    where l.idLote ='$_POST[pesq]' 
    and l.status=1 and l.idOrganizacao=". $_SESSION['idOrganizacao'] ."
    and p.status=1 and p.idOrganizacao=". $_SESSION['idOrganizacao'] ."
    and c.status=1 and c.idOrganizacao=". $_SESSION['idOrganizacao'] ."
    and f.status=1 and f.idOrganizacao=". $_SESSION['idOrganizacao'];

    $sql=mysql_query($sql, $conexao);

    if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($sql)){

        $json[]= array(
            'nome_categoria' => $row['0'],
            'nome_produto' => $row['1'],
            'nome_fornecedor' => $row['2'],
            'valorCompra' => $row['3'],
            'qtde' => $row['4'],
            'validade' => $row['5'],
            'idLote' => $row['6']
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function excluir(){//modificar nao excluir fisicamente. Utilizar campo del
    
    session_start();
    $conexao = AbreBancoJP();

    $sql = "UPDATE loteprodutos set status = 0 where idLote = '$_POST[idLote]' and idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";
    //$sql="DELETE FROM produto WHERE idProduto = '$_POST[id_produto]' and idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";

    mysql_query($sql,$conexao);
    mysql_close($conexao);
}

//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function editarCompraProduto(){

    session_start();
    $conexao=AbreBancoJP();

    $sql="UPDATE loteprodutos set idFornecedor='$_POST[id_fornecedor]', valorCompra='$_POST[valorCompra]', validade='$_POST[validade]', qtde = '$_POST[qtde]'
    WHERE idLote = $_POST[idLote] and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];

    mysql_query($sql, $conexao);
    mysql_close($conexao);

}