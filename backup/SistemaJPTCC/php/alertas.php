<?php


include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'obterVencidos':
        obterVencidos();
        break;

        case 'obterProximosDoVencimento':
        obterProximosDoVencimento();
        break;

        case 'obterQuantidadeChegandoAoFim':
        obterQuantidadeChegandoAoFim();
        break;
    }
}




function obterVencidos(){

    session_start();
    $conexao= AbreBancoJP();

    $sql="
        SELECT 
            lote.idLote,
            prod.nome,
            lotebaixa.`Quantidade`,
            lote.`validade`
        FROM 
            `loteprodutos` as lote
            inner join `loteprodutosbaixa` as lotebaixa on lotebaixa.`LoteProdutosId` = lote.`idLote`
            inner join produto as prod on prod.`idProduto` = lote.`idProduto`
        where
            lote.`validade` < now()
            and lote.status = 1
            and lotebaixa.`FlagStatus` = 1
            and prod.`status` = 1
            and lote.`idOrganizacao` = ".$_SESSION['idOrganizacao'];

    $sql=mysql_query($sql, $conexao);

    if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($sql)){

        $json[]= array(
            'idLote' => $row['0'],
            'nome' => $row['1'],
            'quantidade' => $row['2'],
            'validade' => $row['3']
            );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function obterProximosDoVencimento(){

    session_start();
    $conexao= AbreBancoJP();

    $sql="
        SELECT 
            lote.idLote,
            prod.nome,
            lotebaixa.`Quantidade`,
            lote.`validade`
        FROM 
            `loteprodutos` as lote
            inner join `loteprodutosbaixa` as lotebaixa on lotebaixa.`LoteProdutosId` = lote.`idLote`
            inner join produto as prod on prod.`idProduto` = lote.`idProduto`
        where
            lote.`validade` between now() and DATE_ADD(now(),INTERVAL 2 month)
            and lote.status = 1
            and lotebaixa.`FlagStatus` = 1
            and prod.`status` = 1
            and lote.`idOrganizacao` = ".$_SESSION['idOrganizacao'];

    $sql=mysql_query($sql, $conexao);

    if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($sql)){

        $json[]= array(
            'idLote' => $row['0'],
            'nome' => $row['1'],
            'quantidade' => $row['2'],
            'validade' => $row['3']
            );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function obterQuantidadeChegandoAoFim(){

    session_start();
    $conexao= AbreBancoJP();

    $sql="
        select 
            *
        from 
            ( 
                SELECT 

                    prod.`idProduto`,
                    prod.nome,
                    sum(lotebaixa.`Quantidade`) as qtde
                FROM 
                    `loteprodutos` as lote
                    inner join `loteprodutosbaixa` as lotebaixa on lotebaixa.`LoteProdutosId` = lote.`idLote`
                    inner join produto as prod on prod.`idProduto` = lote.`idProduto`
                where
                    lote.status = 1
                    and lotebaixa.`FlagStatus` = 1
                    and prod.`status` = 1
                    and lote.`idOrganizacao` = ".$_SESSION["idOrganizacao"]."
                    group by prod.`idProduto`
            ) as a 
        where
            a.qtde < 50";

    $sql=mysql_query($sql, $conexao);

    if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($sql)){

        $json[]= array(
            'idProduto' => $row['0'],
            'nome' => $row['1'],
            'quantidade' => $row['2']
            //'validade' => $row['3']
            );
    }

    echo json_encode($json);
    mysql_close($conexao);
}
