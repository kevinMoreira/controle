<?php

/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 27/05/2016
 * Time: 00:19
 */
include '../sistemaJP.php';
require_once('../Ent/Produto.php');
require_once('../Ent/Venda.php');

class VendaDao
{

   public function buscar_produto($codigo){
       session_start();
       $conexao= AbreBancoJP();

       $objProduto = new Produto();

       $sql="SELECT 
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
				nome = '".$codigo."'
			AND
				idOrganizacao =".$_SESSION['idOrganizacao'];

       $sql=mysql_query($sql, $conexao);

       if(mysql_num_rows($sql) <= 0){
           mysql_close($conexao);
           return 0;
       }

       while($row=mysql_fetch_row($sql)){

           $objProduto->setProdutoId($row[0]);
           $objProduto->setCategoriaId($row[1]);
           $objProduto->setNome($row[2]);
           $objProduto->setValor($row[3]);
           $objProduto->setStatus($row[4]);
           $objProduto->setCodigoBarras($row[5]);
       }
       mysql_close($conexao);
       return $objProduto;
   }





function busca(){

    session_start();
    $conexao = AbreBancoJP();

    $sql = "SELECT p.nome, p.valorVenda, sum(l.qtde) from produto p
	INNER JOIN loteprodutos l on l.idProduto = p.idProduto
	where p.idProduto = '$_POST[pesq]' 
	and p.status=1 and p.idOrganizacao=". $_SESSION['idOrganizacao'] ."
	and l.status=1 and l.idOrganizacao=". $_SESSION['idOrganizacao'];

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

    session_start();
    $cancelado = 0;

    if(isset($_POST['cancelado'])){
        $cancelado = 1;
    }

    $conexao= AbreBancoJP();
    $hora = date("H:i:s"); //pega a hora do sistema. Para isso ela precisa estar no fuso horário de são paulo setado no inicio do programa
    $query = "
			insert into venda
			 (
			 	idOrganizacao,
			 	idCliente,
			 	dataVenda,
			 	horaVenda,
			 	cancelado
			 )			  
			values 
			( 
				'$_SESSION[idOrganizacao]', 
				'', 
				curdate(),
				'$hora', 
				$cancelado
			)";//3° posição codigo do cliente possivelmente acrescentarei posteriormente
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

        $lastId = "SELECT idVenda from venda
		where cancelado = 0 and idOrganizacao=". $_SESSION['idOrganizacao'] ." order by idVenda desc limit 1"; //pega id da ultima venda

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

            $valorItem = $qtde[0] * $valor[1];

            $query = "
					insert into item_venda 
					(
						idVenda,
						idProduto,
						qtde,
						subTotal,
						cancelado
					)
					values 
					( 
						$last[0], 
						$idProduto[$i], 
						$qtde[0], 
						$valorItem, 
						$cancelado
					  )"; //insere itens de venda
            $query = mysql_query($query, $conexao); //conexao insere itens de venda

            //=========================================================================================
            // Início da baixa no estoque
            //=========================================================================================
            if($cancelado != 1){
                $qtdeTotalProd = "select sum(qtde) from loteprodutos 
			    where idProduto = '$idProduto[$i]' and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];

                $qtdeTotalProd = mysql_query($qtdeTotalProd, $conexao);
                $qtdeTotalProd = mysql_fetch_row($qtdeTotalProd);

                $qtdeRestante = $qtdeTotalProd[0] - $qtde[0];

                //Pega produto com o prazo de validade mais próximo do vencimento orderby desc
                $qtdeBanco = "select qtde, validade,idlote from loteprodutos
			    where idProduto = '$idProduto[$i]' and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'] ." order by validade desc";

                $qtdeBanco = mysql_query($qtdeBanco, $conexao);

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

                    if($qtdeRestante < 0 && $flag != 1){
                        $validade = $row[1];
                        $qtdeRestante = $qtdeRestante * (-1);

                        if(($row[0] - $qtdeRestante) <= 0){
                            $updateQtde = "UPDATE loteprodutos set qtde = 0, status = 0 
				            where (idProduto = '$idProduto[$i]' and idlote='$row[2]') and status = 1 and idOrganizacao=". $_SESSION['idOrganizacao'];
                            $updateQtde = mysql_query($updateQtde);
                        }else{
                            $updateQtde = "UPDATE loteprodutos set qtde = '$row[0]' - '$qtdeRestante'
					        where (idProduto = '$idProduto[$i]' and idlote = '$row[2]') and status = 1 and idOrganizacao=". $_SESSION['idOrganizacao'];
                            $updateQtde = mysql_query($updateQtde);
                        }

                        $flag=1;
                    }else if($flag == 1){
                        $updateQtde = "UPDATE loteprodutos set qtde = 0, status = 0 
				        where (idProduto = '$idProduto[$i]' and idlote='$row[2]') and status = 1 and idOrganizacao=". $_SESSION['idOrganizacao'];
                        $updateQtde = mysql_query($updateQtde);
                    }
                }
            }
        }
        mysql_close($conexao);
    }
}


}