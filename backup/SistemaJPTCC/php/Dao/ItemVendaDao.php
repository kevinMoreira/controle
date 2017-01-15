<?php

/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 27/05/2016
 * Time: 18:28
 */
class ItemVendaDao
{
    
    public function BuscarProduto(Produto $produto)
    {
        session_start();
        $conexao = AbreBancoJP();

        $objVenda = new Venda();

        $sql = "SELECT 
				`produto`.`idProduto`,
				`produto`.`idCategoria`,
				`produto`.`nome`,
				`produto`.`valorVenda`,
				`produto`.`status`,
				`produto`.`CodigoDeBarras`
			FROM 
				`estoque`.`produto`
			WHERE 
				status=1
			and 
				CodigoDeBarras = '" . $produto->getCodigoBarras() . "'
			AND
				idOrganizacao =" . $_SESSION['idOrganizacao'];

        $sql = mysql_query($sql, $conexao);

        if (mysql_num_rows($sql) <= 0) {
            mysql_close($conexao);
            return 0;
        }

        while ($row = mysql_fetch_row($sql)) {

            $produto->setProdutoId($row[0]);
            $produto->setCategoriaId($row[1]);
            $produto->setNome($row[2]);
            $produto->setValor($row[3]);
            $produto->setStatus($row[4]);
            $produto->setCodigoBarras($row[5]);
        }
        mysql_close($conexao);
        return $produto;

    }

}