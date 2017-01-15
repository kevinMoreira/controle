<?php
/**
 * Created by Kevin Rangel.
 * User: Hp
 * Date: 14/07/2015
 * Time: 23:50
 */
require_once('../Ent/Categoria.php');
include '../sistemaJP.php';

class FornecedorDAO {

    //Retorna endereço cadstrado na base
    public function Obter($pesq){
        session_start();
        $conexao= AbreBancoJP();

        $objFornecedorEnt = new Fornecedor();

        $sql="
            SELECT 
                * 
            from 
                fornecedor
            where 
            (
                    nome='$pesq' 
                OR
                    telefone='$pesq' 
                OR 
                    cnpj='$pesq' 
                or 
                    idfornecedor='$pesq'
            ) 
            and status=1 
            and idOrganizacao=". $_SESSION['idOrganizacao'];

        $sql=mysql_query($sql, $conexao);

         if(mysql_num_rows($sql) <= 0){
            mysql_close($conexao);
            return 0;
        }

        while($row=mysql_fetch_row($sql)){

            $objFornecedorEnt->setFornecedorId($row['0']);
            $objFornecedorEnt->setNome($row['2']);
            $objFornecedorEnt->setCnpj($row['3']);
            $objFornecedorEnt->setTelefone($row['4']);
            $objFornecedorEnt->setEmail($row['5']);
            $objFornecedorEnt->setCep($row['6']);
            $objFornecedorEnt->setEndereco($row['7']);
            $objFornecedorEnt->setNumero($row['8']);
            $objFornecedorEnt->setComplemento($row['9']);
            $objFornecedorEnt->setBairro($row['10']);
            $objFornecedorEnt->setCidade($row['11']);
            $objFornecedorEnt->setUf($row['12']);
            $objFornecedorEnt->setStatus($row['13']);
        }
        mysql_close($conexao);
        return $objFornecedorEnt;
    }

    //Salva endereco na base
     public function Salvar( $fornecedor){
        
        session_start();
        $conexao=AbreBancoJP();

        $sql="
            INSERT INTO fornecedor 
            (
                idOrganizacao,
                nome,
                cnpj,
                telefone,
                email,
                cep,
                endereco,
                numero,
                complemento,
                bairro,
                cidade,
                estado,
                status
            )
            VALUES 
            (
                '$_SESSION[idOrganizacao]',
                '".$fornecedor->getNome()."',
                '".$fornecedor->getCnpj()."',
                '".$fornecedor->getTelefone()."',
                '".$fornecedor->getEmail()."',
                '".$fornecedor->getCep()."',
                '".$fornecedor->getEndereco()."',
                '".$fornecedor->getNumero()."',
                '".$fornecedor->getComplemento()."',
                '".$fornecedor->getBairro()."',
                '".$fornecedor->getCidade()."',
                '".$fornecedor->getUf()."',
                1
            )";

        mysql_query($sql, $conexao);

      
        $retorno = "1";
     
        mysql_close($conexao);

        return $retorno;
    }

    //Atualiza endereco na base
    public function Atualizar(Fornecedor $fornecedor){
        session_start();
        $conexao=AbreBancoJP();

        $sql="UPDATE `fornecedor` SET `nome` = '".$fornecedor->getNome()."',`cnpj` = '".$fornecedor->getCnpj()."',`telefone`= '".$fornecedor->getTelefone()."',`email` = '".$fornecedor->getEmail()."',`cep` = '".$fornecedor->getCep()."',`endereco` = '".$fornecedor->getEndereco()."',`numero` = '".$fornecedor->getNumero()."',`complemento` = '".$fornecedor->getComplemento()."',`bairro` = '".$fornecedor->getBairro()."',`cidade` = '".$fornecedor->getCidade()."',`estado` = '".$fornecedor->getUf()."',`status` = 1,`AtualizacaoDataHora` = current_timestamp() WHERE  `idFornecedor` = ".$fornecedor->getFornecedorId()." AND `idOrganizacao` =". $_SESSION['idOrganizacao'];

        mysql_query($sql, $conexao);


        $retorno = $sql;

        mysql_close($conexao);

        return $retorno;
    }

     public function Excluir(Fornecedor $fornecedor){
         session_start();
         $conexao=AbreBancoJP();

         $sql="
		UPDATE 
			`fornecedor`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp()
	    WHERE 
			`idFornecedor` = ".$fornecedor->getFornecedorId()."		
			AND
			`idOrganizacao` = $_SESSION[idOrganizacao];";

         mysql_query($sql, $conexao);


         $retorno = "1";

         mysql_close($conexao);

         return $retorno;
    }
}