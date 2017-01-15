<?php
/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 13/06/2016
 * Time: 13:53
 */
include '../sistemaJP.php';
$conexao = AbreBancoJP();
// print "<script>var dt1 = prompt('Digite a dada de início', 'Data Inicial');</script>";
$data=$_POST['data1'];
$data2=$_POS0T['data2'];
ob_start();
$sql = "select 
           v.idVenda as NumeroVenda , 
            v.dataVenda as dataHora,
            iv.qtde as quantidade,
            p.nome as produto,
            p.valorVenda,
            l.valorCompra,
            iv.subTotal as Valor,
          
            ((p.valorVenda - l.valorCompra) * iv.qtde) as Lucro
           -- c.nome as Clente
            
            
        from
            venda v,
            item_venda iv,
            produto p,
            loteprodutos l
         
            
        where
           month(v.dataVenda)= month(current_date())
         and 
            v.idOrganizacao=1
        and
            v.idVenda = iv.idVenda
        and
            iv.idProduto = p.idProduto
        and 
            l.idProduto = p.idProduto;";
$sql = mysql_query($sql, $conexao);
?>
<html>
<head>

</head>

<body>
<center>
    <h1>Relat&oacute;rio Mensal</h1>
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        .tg .tg-yw4l{vertical-align:top  }
        #icone{
            font-weight: bold;
        }
    </style>
    <table class="tg">

        <tr>

            <th class="tg-yw4l" id="icone">Numero da venda</th>
            <th class="tg-yw4l" id="icone">Data e hora da venda</th>
            <th class="tg-yw4l" id="icone">Quantidade vendida</th>
            <th class="tg-yw4l" id="icone">Produto</th>
            <th class="tg-yw4l" id="icone">Valor da Venda</th>
            <th class="tg-yw4l" id="icone">Valor Pago no Produto</th>
            <th class="tg-yw4l" id="icone">Valor total</th>

        </tr>
        <?php while ($row = mysql_fetch_row($sql)){ ?>
            <tr>
                <td class="tg-yw4l"><?php echo $row['0'] ?> </td>
                <td class="tg-yw4l"><?php print $row['1'] ?></td>
                <td class="tg-yw4l"><?php echo  $row['2'] ?></td>
                <td class="tg-yw4l"><?php echo $row['3'] ?></td>
                <td class="tg-yw4l"><?php echo $row['4'] ?></td>
                <td class="tg-yw4l"><?php echo $row['5'] ?></td>
                <td class="tg-yw4l"><?php echo $row['6'] ?></td>
                <?php  $lucroTot =  $row['7'] ?>
            </tr>
        <?php }?>
    </table>




</center>


<br>

<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
</style>
<table class="tg">
    <tr>
        <th class="tg-031e">Lucro Total</th>
        <td class="tg-031e"><?php echo $lucroTot ?></td>
    </tr>
    <!--    <tr>-->
    <!--        -->
    <!--    </tr>-->
</table>
</center>
</body>
</html>

<?php
$html = ob_get_clean();
//converter o conteudo para UTF
$html = utf8_encode($html);
//incluir a classe MPDF
include("mpdf60/mpdf.php");
//criar o objeto
$mpdf = new mPDF();
$mpdf->allow_charset_conversion = true;
$mpdf -> charset_in='UF-8';
$mpdf -> WriteHTML($html);
$mpdf->Output('RelatorioSemanal','I');
exit();
?>