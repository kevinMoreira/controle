<?php
/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 04/06/2016
 * Time: 15:22
 */
include '../sistemaJP.php';
$conexao = AbreBancoJP();
session_start();
ob_start();
$sql = "
	select distinct
		item.idVenda,
		ItemLote.`ItemVendaId`,
		prod.`nome`,
		-- ItemLote.`LoteProdutoId`,
		item.`qtde`,
		-- lote.`valorCompra`,
		item.`valorUnitario`,
		-- item.`qtde`,
		(item.`valorUnitario`*item.`qtde`) as subTotal,
		DATE_FORMAT(venda.`dataVenda`,'%d-%m-%Y %H:%i:%s') as data,
		sum(ItemLote.`Quantidade` * (prod.`valorVenda` - lote.`valorCompra`)) as lucro
	from
		item_venda as item
		inner join  produto as prod on prod.`idProduto` = item.`idProduto` 
		inner join ItemVendaLoteProdutos as ItemLote on ItemLote.`ItemVendaId` = item.`idItem`
		inner join loteprodutos as lote on lote.idLote = ItemLote.`LoteProdutoId`
		inner join venda as venda on venda.`idVenda` = item.`idVenda`
	where
		DATE_FORMAT(venda.`dataVenda`,'%m-%d-%Y') = DATE_FORMAT(now(),'%m-%d-%Y') 
		and lote.`idOrganizacao` = ".$_SESSION["idOrganizacao"]."
	group by item.idItem
	order by idVenda;
	";
$sql = mysql_query($sql, $conexao);
$sqlLucroTotal = "
	select
		ifnull(sum(ItemLote.`Quantidade` * (prod.`valorVenda` - lote.`valorCompra`)),0) as lucro
	from
		item_venda as item
		inner join  produto as prod on prod.`idProduto` = item.`idProduto` 
		inner join ItemVendaLoteProdutos as ItemLote on ItemLote.`ItemVendaId` = item.`idItem`
		inner join loteprodutos as lote on lote.idLote = ItemLote.`LoteProdutoId`
		inner join venda as venda on venda.`idVenda` = item.`idVenda`
	where
		DATE_FORMAT(venda.`dataVenda`,'%m-%d-%Y') = DATE_FORMAT(now(),'%m-%d-%Y') 
		and lote.`idOrganizacao`= ".$_SESSION["idOrganizacao"]."
      ";
$lucroTot=0;
$sql2 = mysql_query($sqlLucroTotal, $conexao);
while ($row = mysql_fetch_row($sql2)) {
	$lucroTot = $row[0];
}
?>
<html>
<head>

</head>

<body>
<center>
	<h1>Relat&oacute;rio Di&aacute;rio</h1>
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

			<th class="tg-yw4l" id="icone">Codigo da venda</th>
			<th class="tg-yw4l" id="icone">Codigo do item</th>
			<th class="tg-yw4l" id="icone">Produto</th>
			<th class="tg-yw4l" id="icone">Quantidade</th>
			<th class="tg-yw4l" id="icone">Valor Unitario</th>
			<th class="tg-yw4l" id="icone">SubTotal</th>
			<th class="tg-yw4l" id="icone">Data e hora da venda</th>
			<th class="tg-yw4l" id="icone">Lucro</th>

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
				<td class="tg-yw4l"><?php echo $row['7'] ?></td>
			</tr>
		<?php }?>
	</table>

<br>
	<br>

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

		<tr>

		</tr>
	</table>
</center>
</body>
</html>
<?php
// $html = ob_get_clean();
// //converter o conteudo para UTF
// $html = utf8_encode($html);
// //incluir a classe MPDF
// include("mpdf60/mpdf.php");
// //criar o objeto
// $mpdf = new mPDF();
// $mpdf->allow_charset_conversion = true;
// $mpdf -> charset_in='UF-8';
// $mpdf -> WriteHTML($html);
// $mpdf->Output('RelatorioDiario','I');
// exit();
?>