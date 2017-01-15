<?php
/***
 * @author kevin Rangel Moreira
 * @since 26/03/2016
 * classe conexão banco de dados com a classe produto
 */
include '../sistemaJP.php';
require_once('../Ent/Produto.php');
//adicionando classes da catego


class ProdutoDao{

	
	
	

	public function Obter($pesq)
	{
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
				nome = '".$pesq."'
			OR 
				idProduto = '".$pesq."'
			AND
				idOrganizacao = $_SESSION[idOrganizacao]";
//		print"<script>alert('$_SESSION[idOrganizacao]')</script>";
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


	//Salva categria  na base
	public function Salvar(Produto $produto)
	{
		session_start();
		$conexao=AbreBancoJP();

		$sql="
        INSERT INTO `estoque`.`produto`
		(
			`idOrganizacao`,
			`idCategoria`,
			`nome`,
			`valorVenda`,
			`status`,
			`CadastroDataHora`,
			`CodigoDeBarras`
		)
		VALUES
		(
			-- ".$_SESSION[idOrganizacao].",
			$_SESSION[idOrganizacao],
			  ".$produto->getCategoriaoId().",
			'".$produto->getNome()."',
			".$produto->getValor().",
			1,
			current_timestamp(),
			'".$produto->getCodigoBarras()."'
		);
";

		mysql_query($sql, $conexao);

		$retorno = $sql;
		mysql_close($conexao);
		return $retorno;
	}


	//Atualiza categoria na base
	public function Atualizar(Produto $produto)
	{
		session_start();
		$conexao=AbreBancoJP();
//		print "<script> alert($_SESSION[idOrganizacao]); </script>";
		$sql="
		UPDATE 
			`produto`
		SET
			`idCategoria` = ".$produto->getCategoriaoId().",
			`nome` = '".$produto->getNome()."',
			`valorVenda` = ".$produto->getValor().",
			`AtualizacaoDataHora` = current_timestamp(),
			`CodigoDeBarras` ='".$produto->getCodigoBarras()."'
		WHERE 
			`idProduto` = ".$produto->getProdutoId().";";
//		-- and
//			-- `idOrganizacao` = $_SESSION[idOrganizacao]";

		mysql_query($sql, $conexao);
		$retorno = "1";
		mysql_close($conexao);
		return $retorno;
	}


	public  function  Excluir( Produto $produto){
		session_start();
		$conexao=AbreBancoJP();

//		$sql="
//		UPDATE
//			`produto`
//		SET
//			`status` = 0,
//			`AtualizacaoDataHora` = current_timestamp()
//		WHERE
//			-- `idProduto` = ".$produto->getProdutoId()."
//			`nome` = '".$produto->getNome()."'
//
//			;";
//			and
//			`idOrganizacao` = $_SESSION[idOrganizacao]";

		$sql="UPDATE 
			`produto`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp()
		WHERE 
			`idProduto` = ".$produto->getProdutoId().";";

		mysql_query($sql, $conexao);
		$retorno = "1";
		mysql_close($conexao);

		return $retorno;
	}

	public function CarregarComboBox(){
		session_start();
		$conexao= AbreBancoJP();

		$sql="SELECT 
						idCategoria ,
						nomeCategoria
				FROM 
					categoria 
				WHERE 
					status=1
				AND
					idOrganizacao =".$_SESSION['idOrganizacao'];

		$sql=mysql_query($sql, $conexao);

		if(mysql_num_rows($sql) <= 0){
			mysql_close($conexao);
			return 0;
		}

		while($row=mysql_fetch_row($sql)){
			$json[] = array(
				'id_categoria' => $row[0],
				'nome_categoria'=>$row[1]
			);
		}
		mysql_close($conexao);
		return $json;
	}
}