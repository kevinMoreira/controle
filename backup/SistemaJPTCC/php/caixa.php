<?php

include 'sistemaJP.php';

date_default_timezone_set('America/Sao_Paulo'); //fuso horario

if (isset($_POST['action'])) {
	switch ($_POST['action']) {

		case 'busca':
			busca();
			break;

		case 'criaVenda':
			criaVenda();
			break;

		case 'baixaEstoque':
			baixaEstoque();
			break;
	}
}

function busca(){

	session_start();
	$conexao = AbreBancoJP();

	$sql = "
		SELECT 
			p.nome, 
			p.valorVenda, 
			sum(baixa.Quantidade)
		from 
			produto p
			INNER JOIN loteprodutos l on l.idProduto = p.idProduto
			INNER JOIN LoteProdutosBaixa as baixa on baixa.LoteProdutosId = l.idLote
		where 
			p.idProduto = '$_POST[pesq]' 
			and p.status=1 
			and p.idOrganizacao=". $_SESSION['idOrganizacao'] ."
			and l.status=1 
			and l.idOrganizacao=". $_SESSION['idOrganizacao'] ."
			and baixa.FlagStatus = 1
		group by p.idProduto";

	$sql=mysql_query($sql, $conexao);

	if(mysql_num_rows($sql) <= 0){
		echo '0';
		mysql_close($conexao);
		return;
	}

	while($row = mysql_fetch_row($sql)){

		$json[]= array(
			'nome' => $row['0'],
			'preco' => $row['1'],
			'qtde' => $row['2'],
		);
	}

	echo json_encode($json);
	mysql_close($conexao);
}


//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function criaVenda() {
	//echo "<script>alert('Entrou no cria venda');</script>";
	// echo "<script>alert('sndndnas');</script>";
	session_start();
	$cancelado = 0;

	if(isset($_POST['cancelado'])){
		$cancelado = 1;
	}

	$conexao= AbreBancoJP();
	$hora = date("H:i:s"); //pega a hora do sistema. Para isso ela precisa estar no fuso horário de são paulo setado no inicio do programa
//	$query = "insert into venda values ('', '$_SESSION[idOrganizacao]', '', curdate(),'$hora', $cancelado)";//3° posição codigo do cliente possivelmente acrescentarei posteriormente
	$query = "
		insert into venda
		(
			idOrganizacao,
			idCliente,
			horaVenda,
			cancelado
		) 
		values
		(
			".$_SESSION["idOrganizacao"].",
			0,
			CURRENT_TIME ,
			$cancelado
		);";
	mysql_query($query, $conexao);
	mysql_close($conexao);
}

function baixaEstoque() {//dá baixa no estoque seguindo a regra de negócio

	session_start();
	if(isset($_POST['idProduto']) && isset($_POST['qtde']) && isset($_POST['valor'])){

		$idProdutos = $_POST['idProduto']; //recebe string de produtos
		$getQtde = $_POST['qtde']; //recebe string de quantidade
		$getValor = $_POST['valor']; //recebe string de valor
		$getSubtotal = $_POST['subtotal'];//recebe string de subtotal
		$idProduto = explode(",", $idProdutos); //quebra a string em vetor na virgula, nunca usar mesma varável, pois dá conflito
		$exp_qtde = explode(",", $getQtde); //quebra a string em vetor na virgula
		$exp_valor = explode(",", $getValor);//quebra a string em vetor na virgula
		$exp_subtotal = explode(",", $getSubtotal);//quebra a string em vetor na virgula
		$conexao= AbreBancoJP();//abre conexao

		$lastId = "
			SELECT 
				idVenda 
			from 
				venda
			where 
				cancelado = 0 
				and idOrganizacao=". $_SESSION['idOrganizacao'] ." 
			order by idVenda desc limit 1"; //pega id da ultima venda

		$lastId = mysql_query($lastId, $conexao);
		$last = mysql_fetch_row($lastId); //percorre vetor

		for ($i = 0; $i < sizeof($idProduto); $i++) {

			$cancelado = 0;
			$qtde = explode("x", $exp_qtde[$i]);//valor retirado da tabela necessita ser explodido dentro da iteração
			$valor = explode("R$", $exp_valor[$i]);//valor retirado da tabela necessita ser explodido dentro da iteração

			if ($exp_subtotal[$i] != '0') {
				$subtotal = explode("R$", $exp_subtotal[$i]);//valor retirado da tabela necessita ser explodido dentro da iteração
			}else{
				$cancelado = 1;
			}

			//$valorItem = $qtde[0] * $valor[1];


			//$query = "insert into item_venda values ('', $last[0], $idProduto[$i], $qtde[0], $valorItem, $cancelado)"; //insere itens de venda
			$query = "
				insert into item_venda
				(
					idVenda,
					idProduto,
					qtde,
					valorUnitario,
					cancelado
				) 
				values 
				( 
					$last[0], 
					$idProduto[$i], 
					$qtde[0], 
					$valor[1], 
					$cancelado
				);";

				//echo $query . "\n";
			//lastInsertItemVendaId = 0;
			$query  = mysql_query($query, $conexao); //conexao insere itens de venda

			$query = "select LAST_INSERT_ID();";

			$query  = mysql_query($query, $conexao); //conexao insere itens de venda

			$lastInsertItemVendaId = mysql_fetch_row($query)[0];
			//echo $lastInsertItemVendaId."\n";


			//=========================================================================================
			// Início da baixa no estoque
			//=========================================================================================
			if($cancelado != 1){
				
//			    $qtdeTotalProd = "select sum(qtde) from loteprodutos
//			    where idProduto = '$idProduto[$i]' and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];

				$qtdeTotalProd ="

				 select 
					sum(baixa.quantidade) as total 
				from 
					loteprodutosbaixa as baixa
					INNER JOIN loteprodutos as lote on lote.`idLote` = baixa.`LoteProdutosId`
				where			
					lote.`idProduto` = ".$idProduto[$i]."
					and lote.status=1 
					and baixa.`FlagStatus` = 1
					and lote.idOrganizacao=$_SESSION[idOrganizacao];
				 ";

				$qtdeTotalProd = mysql_query($qtdeTotalProd, $conexao);
				$qtdeTotalProd = mysql_fetch_row($qtdeTotalProd);
				//quantidade total de produtos qtde, quantidade total do banco - qtd inserida
				//pelo usuário 
				$qtdeRestante = $qtdeTotalProd[0] - $qtde[0];

				//Pega produto com o prazo de validade mais próximo do vencimento orderby desc
				// $qtdeBanco = "select qtde, validade,idlote from loteprodutos
				// where idProduto = '$idProduto[$i]' and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'] ." order by validade desc limit 1";

				$qtdeBanco="
						select 
							ifnull(baixa.Quantidade,0) as qtde, 
							lote.validade, 
							lote.idlote							
						from 
							loteprodutos as lote
							inner join loteprodutosbaixa as baixa on baixa.`LoteProdutosId` = lote.idLote
						where 
							lote.idProduto = ".$idProduto[$i]."
							and lote.status=1
							and baixa.FlagStatus = 1
							and lote.idOrganizacao=". $_SESSION['idOrganizacao'] ."
						order by lote.validade desc;";

				$qtdeBanco = mysql_query($qtdeBanco, $conexao);

				//tem q fazer a soma no banco e não pegar de um prduto só quando tem 2
				$validade = 0;

				/*a baixa no estoque é feita da seguinte forma: obtem-se o total da qtde do mesmo produto em todos os lotes
                e subtrai-se pela qtde a retirar. O resultado do cálculo é a qtde que deve restar após a baixa no estoque.
                Então faz-se um select decrescente pela validade nos lotes subtraindo a quantidade a retirar
                com a qtde real naquele lote, quando essa subtração der um valor negativo o if abaixo entra em ação multiplicando
                o valor negativo por -1 e depois subtraindo com a qtde real do produto naquele lote dando um UPDATE.
                feito isso faz-se um outro select decrescente na validade zerando o status e a quantidade dos lotes com a data
                de vencimento mais próxima.*/

				//A flag serve para verificar se entrou no if que determina o desconto na qtde apartir de um calculo feito,
				//para que no proximo item de data de vencimento mais curta, tenha a qtde zerada
				$flag=0;

				while($row = mysql_fetch_row($qtdeBanco)){

					$qtdeRestante = $qtdeRestante - $row[0];

						if ($qtdeRestante < 0 && $flag != 1) {

							//$validade = $row[1];
							$qtdeRestante = $qtdeRestante * (-1);

							//$teste= $row[0] - $qtdeRestante;

							if (($row[0] - $qtdeRestante) <= 0) {

								$sqlItemVendaLoteProdutos = "
								insert into ItemVendaLoteProdutos
								(
									ItemVendaId,
									LoteProdutoId,
									Quantidade
								)
								select 
									".$lastInsertItemVendaId.",
									a.`LoteProdutosId`,
									a.`Quantidade`
								from 
									`loteprodutosbaixa` as a 
								where
									a.`LoteProdutosId` = ".$row["2"];

								mysql_query($sqlItemVendaLoteProdutos, $conexao);
//echo "flag == 0 -->>";
								
								$updateQtde = "
									UPDATE 
										loteprodutos as a 
										inner join loteprodutosbaixa as b on b.LoteProdutosId = a.idLote
									set 
										b.Quantidade = 0, 
										b.FlagStatus = 0,
										a.Status = 0,
										b.CadastroDataHora = current_timestamp()
						            where 
						            	(a.idProduto = ".$idProduto[$i]." and a.idlote= ".$row["2"].") 
						            	and status = 1 
						            	and a.idOrganizacao=" . $_SESSION["idOrganizacao"];

								$updateQtde = mysql_query($updateQtde, $conexao);
								
							} else {
								//echo "subtracao-->>";
								$updateQtde = "
									UPDATE 
										loteprodutos as a 
										inner join loteprodutosbaixa as b on b.LoteProdutosId = a.idLote
									set 
										b.Quantidade = '$row[0]' - '$qtdeRestante',
										b.CadastroDataHora =  current_timestamp()

							        where 
							        	(idProduto = '$idProduto[$i]' and idlote = '$row[2]') 
							        	and status = 1 
							        	and idOrganizacao=" . $_SESSION['idOrganizacao'];
									$updateQtde = mysql_query($updateQtde, $conexao);


								$sqlItemVendaLoteProdutos = "
									insert into ItemVendaLoteProdutos
									(
										ItemVendaId,
										LoteProdutoId,
										Quantidade
									)
									select 
										".$lastInsertItemVendaId.",
										a.`LoteProdutosId`,
										$qtdeRestante
									from 
										`loteprodutosbaixa` as a 
									where
										a.`LoteProdutosId` = ".$row["2"];

								echo $sqlItemVendaLoteProdutos;
								mysql_query($sqlItemVendaLoteProdutos, $conexao);
								echo $sqlItemVendaLoteProdutos;
							}

							$flag = 1;
						} 

						else if ($flag == 1) {
							//echo "flag == 1 -->>";
							$sqlItemVendaLoteProdutos = "
								insert into ItemVendaLoteProdutos
								(
									ItemVendaId,
									LoteProdutoId,
									Quantidade
								)
								select 
									".$lastInsertItemVendaId.",
									a.`LoteProdutosId`,
									a.`Quantidade`
								from 
									`loteprodutosbaixa` as a 
								where
									a.`LoteProdutosId` = ".$row["2"];

							mysql_query($sqlItemVendaLoteProdutos, $conexao);

							//echo $sqlItemVendaLoteProdutos;
							$updateQtde = "
								UPDATE 
									loteprodutos as a 
									inner join LoteProdutosBaixa as b on b.LoteProdutosId = a.idLote
								set 
							        Quantidade = 0, 
							        status = 0,
								    FlagStatus = 0,
								    b.CadastroDataHora = current_timestamp()
						        where 
						        
						        	(idProduto = '$idProduto[$i]' and idlote='$row[2]') 
						        	and status = 1 
						        	and idOrganizacao=" . $_SESSION['idOrganizacao'];
							$updateQtde = mysql_query($updateQtde, $conexao);
						}
				}
			}
		}


		mysql_close($conexao);
	}
}
