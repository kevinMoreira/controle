<?php

include 'sistemaJP.php';

date_default_timezone_set('America/Sao_Paulo'); //fuso horario

if (isset($_POST['action'])) {

    switch ($_POST['action']) {

        case 'produtos':
            produtos();
            break;

        case 'criaVenda':
            criaVenda();
            break;
    }
}

//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function criaVenda() {

    $conexao = AbreBancoJP();

    if (isset($_POST['idCliente'])) {

        $idCliente = $_POST['idCliente']; //recebe id do cliente para inserir na venda

        $valor = $query2['valorDeVenda'];
    } else {

        $idCliente = 0;
    }

    $hora = date("H:i:s"); //pega a hora do sistema. Para isso ela precisa estar no fuso horário de são paulo setado no inicio do programa

    $query = "insert into venda values ('', '$_SESSION[idOrganizacao]', $idCliente', curdate(),'$hora')";

    $query = mysql_query($query, $conexao);

    mysql_close($conexao);
}

function produtos() {

    $produtos = $_POST['codigo']; //recebe string de produtos

    $quantidade = $_POST['qtde']; //recebe string de quantidade

    $prod = explode(",", $produtos); //quebra a string em vetor na virgula

    $qtde = explode(",", $quantidade); //quebra a string em vetor na virgula


    $conexao = AbreBancoJP();

    $lastId = "select idVenda from venda order by idVenda desc limit 1"; //pega id da ultima venda

    $lastId = mysql_query($lastId, $conexao);

    $last = mysql_fetch_row($lastId); //percorre vetor

    if (isset($_POST['idCliente2'])) {

        $idCliente = $_POST['idCliente2']; //recebe id do cliente para inserir no item_venda
    } else {

        $idCliente = 0;
    }

    $valor = 0;

    for ($i = 0; $i < sizeof($prod) - 1; $i++) {

        $valorItem = "select $qtde[$i] * valorVenda as valorItem "
                . "from produto "
                . "where idProduto=$prod[$i] ";

        $valorItem = mysql_query($valorItem, $conexao);

        $valorItem = mysql_fetch_row($valorItem); //percorre vetor

        $query = "insert into item_venda values ('', $last[0], $prod[$i], $qtde[$i], $valorItem[0])"; //insere itens de venda

        $query = mysql_query($query, $conexao); //conexao insere itens de venda

        $query2 = "select l.qtde from produto p "
                . "inner join loteprodutos l on p.idProduto=l.idProduto "
                . "where p.idProduto = '$prod[$i]'"; //seleciona qtde do produto

        $query2 = mysql_query($query2, $conexao); //conexao seleciona qtde do produto

        $query2 = mysql_fetch_row($query2); //percorre vetor

        if ($idCliente > 0) {

            $valor += $valorItem[0];
        }

        $query3 = "UPDATE loteprodutos SET qtde = $query2[0] - $qtde[$i] WHERE idProduto = $prod[$i]"; //retira produto do estoque

        $query3 = mysql_query($query3, $conexao); //conexao retira produto do estoque
    }

    // $query4 = "update conta set saldoConta = $valor + saldoConta where idCliente = $idCliente";

    // $query4 = mysql_query($query4, $conexao);

    mysql_close($conexao);
}

?>