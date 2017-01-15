<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 14/07/2015
 * Time: 23:50
 */
include '../sistemaJP.php';
//require_once('../MySQL.php');
require_once('../Ent/Cliente.php');

class ClienteDAO {

//    //Retorna endereço cadstrado na base
//    public function Obter($pesquisa){
//        $conexao = new MySQL();
//        $objCliente= new Cliente();
//        //Seleciona endereço na base
//        $sql="set @PESQUISA = '$pesquisa'; call USP_SEL_ENDERECO(@PESQUISA);";
//        $retorno = $conexao->execSP($sql);
//
//        //Se endereço não existir realiza uma busca no web service
//        if($retorno != null)
//        {
//            $objCliente->setNome($retorno["nome"]);
//            $objCliente->setIdCliente($retorno["bairro"]);
//            $objCliente->setIdOrganizacao($retorno["cidade"]);
//            $objCliente->setNome($retorno["estado"]);
//            $objCliente->setCpf($retorno["cpf"]);
//            $objCliente->setDataNascimento($retorno["dataNascimento"]);
//            $objCliente->setTelefone($retorno["telefone"]);           
//            $objCliente->setCelular($retorno["celular"]);
//            $objCliente->setEmail($retorno["email"]);
//            $objCliente->setCep($retorno["cep"]);
//            $objCliente->setEndereco($retorno["endereco"]);
//            $objCliente->setNumero($retorno["numero"]);
//            $objCliente->setComplemento($retorno["complemento"]);
//            $objCliente->setBairro($retorno["bairro"]);
//            $objCliente->setCidade($retorno["cidade"]);
//            $objCliente->setUf($retorno["uf"]);
//            // $objCliente->setStatus($retorno["CadastroDataHora"]);
//            // $objCliente->setComplemento($retorno["Complemento"]);
//        }else{
//            // $objEndereco = $this->ConsultarWebServiceEndereco($cep);
//            $this->Salvar($objCliente);
//        }
//        return $objCliente;
//    }
//
//    //Retorna endereço consultado no web service apimon
//    private function ConsultarWebServiceEndereco($cep){
//        $objEndereco = new eEndereco();
//        $jsonEndereco = file_get_contents('http://api.postmon.com.br/v1/cep/'.$cep);
//        $objEndereco->setLogradouro(utf8_decode($jsonEndereco["Logradouro"]));
//        $objEndereco->setBairro(utf8_decode($jsonEndereco["Bairro"]));
//        $objEndereco->setCidade(utf8_decode($jsonEndereco["Cidade"]));
//        $objEndereco->setEstado(utf8_decode($jsonEndereco["Estado"]));
//        $objEndereco->setCep(utf8_decode($jsonEndereco["Cep"]));
//
//        return $objEndereco;
//    }
//
//    //Salva endereco na base
//    private function Salvar(Cliente $cliente){
//        $conexao= new MySQL();
//        $objCliente= new Cliente();
//        //Seleciona endereço na base
//        $sql="set @NOME = '$cliente->getNome()';
//        set @BAIRRO = '$cliente->getBairro()';
//        
//        set @ESTADO = '$cliente->getEstado()';
//        set @CPF = '$cliente->getCpf()';
//        set @DARTANASCIMENTO = '$cliente->getDataNascimento()';
//        set @TELEFONE = '$cliente->getTelefone()';
//        set @CELULAR = '$cliente->getCeluar()';
//        set @EMAIL ='$cliente->getEmail()';
//        set @CEP = '$cliente->getCep()';
//        set @ENDERECO = '$cliente->getEndereco()';
//        set @NUMERO = '$cliente->getNumero()';
//        set @COMPLEMENTO = '$cliente->getComplemento()';
//        set @BAIRRO = '$cliente->getBairro()';
//        set @ENDERECO = '$cliente->getEndereco()';
//        set @CIDADE = '$cliente->getCidade()';
//        
//        call USP_INS_ENDERECO(@CEP, @LOGRADOURO, @BAIRRO, @CIDADE, @ESTADO);";
//        $retorno = $conexao->execSP($sql);
//    }
//
//    //Atualiza endereco na base
//    private function Atualizar(eEndereco $endereco){
//        $conexao= new MySQL();
//        $objEndereco= new eEndereco();
//        //Seleciona endereço na base
//        $sql="set @CEP = '$endereco->getCep()';
//        set @LOGRADOURO = '$endereco->getLogradouro()';
//        set @BAIRRO = '$cep';
//        set @CIDADE = '$cep';
//        set @ESTADO = '$cep';
//        call USP_UPD_ENDERECO(@CEP, @LOGRADOURO, @BAIRRO, @CIDADE, @ESTADO);";
//        $retorno = $conexao->execSP($sql);
//    }


//O codigo começa aqui
    public function Salvar(Cliente $objClienteEnt)
    {
        session_start();
        $conexao=AbreBancoJP();




        $sql="INSERT INTO `cliente`
		(
		    `idOrganizacao`,
			`nome`,
			`cpf`,
			`data_nascimento`,
			`telefone`,
			`celular`,
			`email`,
			`cep`,
            `numero`,
			`complemento`,
			`status`,
			`CadastroDataHora`,
			`CadastroUsuarioId`,
			`AtualizacaoDataHora`,
			`AtualizacaoUsuarioId`,
			`bairro`,
			`cidade`,
			`uf`,
			`endereco`
		)
        VALUES		
        (
			-- ".$objClienteEnt->getIdOrganizacao().",
			 $_SESSION[idOrganizacao],
			'".$objClienteEnt->getNome()."',
			'".$objClienteEnt->getCpf()."',
			'".$objClienteEnt->getDataNasc()."',
			'".$objClienteEnt->getTelefone()."',
			'".$objClienteEnt->getCelular()."',
			'".$objClienteEnt->getEmail()."',
			'".$objClienteEnt->getCep()."',
			'".$objClienteEnt->getNumero()."',
            '".$objClienteEnt->getComplemento()."',
			1,
			current_timestamp(),
			1,
			NULL,
			NULL,
			'".$objClienteEnt->getBairo()."',
			'".$objClienteEnt->getCidade()."',
			'".$objClienteEnt->getUf()."',
			'".$objClienteEnt->getEndereco()."');";
        mysql_query($sql, $conexao);

        $retorno = "1";
        mysql_close($conexao);
        return $retorno;
    }


    //pesquisar cliente
    public function Obter($pesq)
    {

        session_start();
        $conexao = AbreBancoJP();


        $objClienteEnt = new Cliente();

        $sql = "SELECT 
				nome
            ,	idCliente
			,	idOrganizacao
			,	nome
			,	cpf
			,	data_nascimento
			,	telefone
			,	celular
			,	email
			,	cep
			,	endereco
			,	numero
			,	complemento
			,	bairro
			,	cidade
			,	uf
			,	status
			,	CadastroDataHora
			,	CadastroUsuarioId
			,	AtualizacaoDataHora
			,	AtualizacaoUsuarioId
		FROM 
			cliente 
		WHERE
			-- (IDCLIENTE=   ".$objClienteEnt->getIdCliente()." )
            -- AND
            (
				NOME = '".$pesq."' 
                OR
                telefone = '".$pesq."'
			)
		AND 
			status=1
		  AND
		  idOrganizacao =".$_SESSION['idOrganizacao'];
//        idOrganizacao =".$objClienteEnt->getIdOrganizacao();
//

        $sql = mysql_query($sql, $conexao);

        if (mysql_num_rows($sql) <= 0) {
            mysql_close($conexao);
            return 0;
        }

        while ($row = mysql_fetch_row($sql)) {


            $objClienteEnt->setNome($row['0']);
            $objClienteEnt->setIdCliente($row['1']);
            $objClienteEnt->setIdOrganizacao($row['2']);
            $objClienteEnt->setNome($row['3']);
            $objClienteEnt->setCpf($row['4']);
            $objClienteEnt->setDataNasc($row['5']);
            $objClienteEnt->setTelefone($row['6']);
            $objClienteEnt->setCelular($row['7']);
            $objClienteEnt->setEmail($row['8']);
            $objClienteEnt->setCep($row['9']);
            $objClienteEnt->setEndereco($row['10']);
            $objClienteEnt->setNumero($row['11']);
            $objClienteEnt->setComplemento($row['12']);
            $objClienteEnt->setBairo($row['13']);
            $objClienteEnt->setCidade($row['14']);
            $objClienteEnt->setUf($row['15']);
            $objClienteEnt->setStatus($row['16']);
            $objClienteEnt->setDataHoraCadastro($row['17']);
            $objClienteEnt->setIdUsuario($row['18']);
            $objClienteEnt->setDataHoraAtualizacao($row['19']);
            $objClienteEnt->setIdUsuarioAtulaizacao($row['20']);

        }
        mysql_close($conexao);
        return $objClienteEnt;
    }




//    public function Excluir(Cliente $objClienteEnt)
//    {
//        session_start();
//        $conexao=AbreBancoJP();
//
//
//        $sql="	UPDATE 
//			`cliente`
//		SET
//			`status` = 0,
//			`AtualizacaoDataHora` = current_timestamp()
//            -- `AtualizacaoUsuarioId` = ".$objClienteEnt->getIdUsuario()."
//		WHERE 
//			 `idCliente` = ".$objClienteEnt->getIdCliente()."
//			 -- `idCliente` = 99
//			
//		AND
//			 `idOrganizacao`= 1;";
//
//        mysql_query($sql, $conexao);
//
//
//        $retorno = "1";
//        mysql_close($conexao);
//        return $retorno;
//    }


    public function Excluir($id)
    {
        session_start();
        $conexao=AbreBancoJP();


        $sql="	UPDATE 
			`cliente`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp()
           
		WHERE 
			 `idCliente` = ".$id."
			 -- `idCliente` = 99
			
		AND
			 `idOrganizacao`= 1;";

        mysql_query($sql, $conexao);


        $retorno = "1";
        mysql_close($conexao);
        return $retorno;
    }



    public function Atualizar($id, $nome , $cpf,
                              $data_nascimento, $telefone, $celular, $email,
                              $cep, $endereco, $numero,$complemento,
                              $bairro,$cidade, $uf, $status)
    {
        session_start();
        $conexao=AbreBancoJP();


        $sql="	UPDATE 
			cliente
		SET
			`telefone` = '".$telefone."',
			
			`celular` = '".$celular."',
			`email` = '".$email."',
			`cep` =  '".$cep."',
            `numero` =  '".$numero."',
            `complemento` = '".$complemento."',
			`AtualizacaoDataHora` = current_timestamp(),
			
			`AtualizacaoUsuarioId` = ".$id.",
			
		 `bairro`='".$bairro."',
			
		`cidade`='".$cidade."',
		 `nome`='".$nome."',
		 `cpf`='".$cpf."',
		 `data_nascimento`= '".$data_nascimento."',
		 `endereco`='".$endereco."',
		 `uf`='".$uf."'
			
		-- `status`=".$status."
			
		WHERE 
			`idCliente` = ".$id."
		AND
			`idOrganizacao`= 1;";

        mysql_query($sql, $conexao);


        $retorno = "1";
        mysql_close($conexao);
        return $retorno;
    }
} 