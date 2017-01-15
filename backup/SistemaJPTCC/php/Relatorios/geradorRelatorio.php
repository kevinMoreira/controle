<?php
/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 04/06/2016
 * Time: 14:51
 */

include '../sistemaJP.php';


function relatorioDiario()
{
         $conexao = AbreBancoJP();

            $sql = "select 
            v.idVenda as NumeroVenda , 
            v.dataVenda as dataHora,
            iv.qtde as quantidade,
            p.nome as produto,
            p.valorVenda,
            l.valorCompra,
            iv.subTotal as Valor
           -- c.nome as Clente
            
            
        from
            venda v,
            item_venda iv,
            produto p,
            loteprodutos l
          --  cliente c
            
        where
            v.dataVenda=current_date()
        and 
            v.idOrganizacao=1
        and
            v.idVenda = iv.idVenda
        and
            iv.idProduto = p.idProduto
        and 
            l.idProduto = p.idProduto;
        -- and
        -- 	v.idCliente = c.idCliente;";


    $sql = mysql_query($sql, $conexao);

    $row = mysql_fetch_row($sql);
}