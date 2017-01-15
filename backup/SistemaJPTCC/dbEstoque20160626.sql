-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 27-Jun-2016 às 03:33
-- Versão do servidor: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `estoque`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_INS_CADASTRO_USUARIO`(
	ORGANIZACAO_ VARCHAR(30),
	NOME VARCHAR(30),
	TELEFONE VARCHAR(30),
	EMAIL VARCHAR(30),
	SENHA VARCHAR(30)	
)
BEGIN
	
    -- VERIFICA SE JÁ EXISTE UM USUÁRIO COM MESMO LOGIN, CASO NÃO CRIA UM NOVO USUÁRIO
	IF(NOT exists(SELECT * FROM usuarios AS USU WHERE USU.login = EMAIL and status=1))
    THEN
		-- CRIA ORGANZACAO
		INSERT INTO organizacao
		(
			nome,
			STATUS,
			CadastroDataHora
		)
		VALUES
		(
			ORGANIZACAO_,
			1,
			CURRENT_TIMESTAMP()
		);
		-- RECUPERA ID DA NOVA ORGANIZACAO
		SET @ID_ORGANIZACAO = LAST_INSERT_ID();
		-- CRIA USUÁRIO
		INSERT INTO usuarios
		(
			idOrganizacao,
			idDepartamento,
			nome,
			cpf,
			telefone,
			email,
			login,
			senha,
			permissao,
			STATUS,
			CadastroDataHora,
			Token,
			DataValidadeToken
		)
		VALUES
		(
			@ID_ORGANIZACAO,
			NULL,
			NOME,
			NULL,
			TELEFONE,
			EMAIL,
			EMAIL,
			MD5(SENHA),
			2,
			1,
			CURRENT_TIMESTAMP(),
			(SELECT md5(FLOOR(RAND() * 1000000))),-- TOKEN
			(select DATE_ADD(current_timestamp(), INTERVAL 7 DAY))-- DATA VALIDADE TOKEN DATA HOJE + 7 DIAS
		);
		-- RECUPERA ID DO NOVO USUÁRIO
		SET @ID_NOVO_USUARIO = LAST_INSERT_ID();
	/*	
        -- LIBERACAO DE MENU
		INSERT controle_menu
		(
			idUsuario,
			idMenu,
			idOrganizacao,
			CadastroDataHora        
		)
		SELECT
			@ID_NOVO_USUARIO,
			idMenu,
			@ID_ORGANIZACAO,
			CURRENT_TIMESTAMP()
		FROM 
			menu
		WHERE
			status = 1;
			
		-- LIBERACAO DE SUB MENU
		INSERT controle_submenu
		(
			idUsuario,
			idSubMenu,
			idOrganizacao,
			CadastroDataHora        
		)
        */
		SELECT
			@ID_NOVO_USUARIO,
			idSubMenu,
			@ID_ORGANIZACAO,
			CURRENT_TIMESTAMP()
		FROM 
			sub_menu
		WHERE
			status = 1;
		
        -- RECUPERA INFORMAÇÕES DO NOVO USUÁRIO
		SELECT 
				nome
			,	email
            ,	telefone
            ,	Token
            , 	CadastroDataHora
		FROM 
			usuarios
		WHERE
			idUsuario = @ID_NOVO_USUARIO;
	ELSE
		SELECT 0;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_MANTER_CATEGORIAS`(
	NOME_ VARCHAR(30),
    ID_ORGANIZACAO INT,
    ID_CATEGORIA INT,
    STATUS_ BIT,
    PESQUISA VARCHAR(50),
    ID_PARAMETRO_CONSULTA INT 	
)
BEGIN
	
	IF(ID_PARAMETRO_CONSULTA = 0)
	THEN

		INSERT INTO categoria
		(
			`idOrganizacao`,
			`nomeCategoria`,
			`status`,
			`CadastroDataHora`,
			`CadastroUsuarioId`,
			`AtualizacaoDataHora`,
			`AtualizacaoUsuarioId`
		)
		VALUES
		(
			ID_ORGANIZACAO,
			NOME_,
			1,
			current_timestamp(),
			NULL,
			NULL,
			NULL
        );

	ELSEIF(ID_PARAMETRO_CONSULTA = 1)
    THEN
		UPDATE 
			`categoria`
		SET
			`nomeCategoria` = NOME_,
			`status` = STATUS_,
			`AtualizacaoDataHora` = current_timestamp()
		WHERE 
			`idCategoria` = ID_CATEGORIA
		AND
			`idOrganizacao`= ID_ORGANIZACAO;
            
	ELSEIF(ID_PARAMETRO_CONSULTA = 2)
    THEN
		UPDATE 
			`categoria`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp()
		WHERE 
			`idCategoria` = ID_CATEGORIA
		AND
			`idOrganizacao`= ID_ORGANIZACAO;
	
    ELSEIF(ID_PARAMETRO_CONSULTA = 3)
    THEN
		SELECT 
				idCategoria 
			,	nomeCategoria
		FROM 
			categoria 
		WHERE
		-- 	(idCategoria= ID_CATEGORIA OR ID_CATEGORIA IS NULL)
         --   AND
         --   (nomeCategoria LIKE CONCAT('%', PESQUISA, '%') OR PESQUISA IS NULL)
		-- AND 
			status=1
		AND
			idOrganizacao = ID_ORGANIZACAO;
            
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_MANTER_CLIENTES`(
	NOME_ VARCHAR(30),
    ID_ORGANIZACAO INT,
    ID_CATEGORIA INT,
    STATUS_ BIT,
    PESQUISA VARCHAR(50),
    CPF VARCHAR(20),
    DATA_NASC DATETIME,
    TELEFONE VARCHAR(20),
    CELULAR VARCHAR(20),
    EMAIL VARCHAR(50),
    CEP VARCHAR(12),
    ENDERECO VARCHAR(100),
    NUMERO VARCHAR(20),
    COMPLEMENT0 VARCHAR(20),	
    ID_CLIENTE INT,
    ID_PARAMETRO_CONSULTA INT 	
)
BEGIN
	
	IF(ID_PARAMETRO_CONSULTA = 0)
	THEN
		INSERT INTO `cliente`
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
			`AtualizacaoUsuarioId`
		)
        VALUES
		(
			ID_ORGANIZACAO,
			NOME_,
			CPF,
			DATA_NASC,
			TELEFONE,
			CELULAR,
			EMAIL,
			CEP,
			NUMERO,
            COMPLEMENTO,
			1,
			current_timestamp(),
			NULL,
			NULL,
			NULL
        );

	ELSEIF(ID_PARAMETRO_CONSULTA = 1)
    THEN
		UPDATE 
			cliente
		SET
			`telefone` = TELEFONE,
			`celular` = CELULAR,
			`email` = EMAIL,
			`cep` =  CEP,
            `numero` =  NUMERO,
            `complemento` = COMPLEMENTO,
			`AtualizacaoDataHora` = current_timestamp(),
			`AtualizacaoUsuarioId` = ID_USUARIO
		WHERE 
			`idCliente` = ID_CLIENTE
		AND
			`idOrganizacao`= ID_ORGANIZACAO;
            
	ELSEIF(ID_PARAMETRO_CONSULTA = 2)
    THEN
		UPDATE 
			cliente
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp(),
            `AtualizacaoUsuarioId` = ID_USUARIO
		WHERE 
			`idCliente` = ID_CLIENTE
		AND
			`idOrganizacao`= ID_ORGANIZACAO;
	
    ELSEIF(ID_PARAMETRO_CONSULTA = 3)
    THEN
		SELECT 
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
			(IDCLIENTE= ID_CLIENTE OR ID_CLIENTE IS NULL)
            AND
            (
				(NOME LIKE ('%'+PESQUISA+'%') OR PESQUISA IS NULL)
                OR
                (telefone LIKE ('%'+PESQUISA+'%') OR PESQUISA IS NULL)
			)
		AND 
			status=1
		AND
			idOrganizacao = ID_ORGANIZACAO;
            
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_MANTER_DEPARTAMENTOS`(
	NOME_ VARCHAR(30),
    ID_ORGANIZACAO INT,
    ID_DEPARTAMENTO INT,
    STATUS_ BIT,
    PESQUISA VARCHAR(50),
    ID_PARAMETRO_CONSULTA INT 	
)
BEGIN

	IF(ID_PARAMETRO_CONSULTA = 0)
	THEN
		INSERT INTO `departamento`
		(
			idDepartamento,
			idOrganizacao,
			nome,
			status,
			CadastroDataHora,
			CadastroUsuarioId,
			AtualizacaoDataHora,
			AtualizacaoUsuarioId
		)
        VALUES
		(
			ID_DEPARTAMENTO,
			ID_ORGANIZACAO,
			NOME,
			1,
			current_timestamp(),
			ID_USUARIO,
			NULL,
			NULL
        );

	ELSEIF(ID_PARAMETRO_CONSULTA = 1)
    THEN
		UPDATE 
			departamento
		SET
			`nome` = NOME,
			`AtualizacaoDataHora` = current_timestamp(),
			`AtualizacaoUsuarioId` = ID_USUARIO
		WHERE 
			`idDepartamento` = ID_DEPARTAMENTO
		AND
			`idOrganizacao`= ID_ORGANIZACAO;
            
	ELSEIF(ID_PARAMETRO_CONSULTA = 2)
    THEN
		UPDATE 
			departamento
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp(),
            `AtualizacaoUsuarioId` = ID_USUARIO
		WHERE 
			`idDepartamento` = ID_DEPARTAMENTO
		AND
			`idOrganizacao`= ID_ORGANIZACAO;
	
    ELSEIF(ID_PARAMETRO_CONSULTA = 3)
    THEN
		SELECT 
				idDepartamento
			,	idOrganizacao
			,	nome
			,	status
			,	CadastroDataHora
			,	CadastroUsuarioId
			,	AtualizacaoDataHora
			,	AtualizacaoUsuarioId
		FROM 
			departamento 
		WHERE
			(idDepartamento= ID_DEPARTAMENTO OR ID_DEPARTAMENTO IS NULL)
		AND
			(nome LIKE ('%'+PESQUISA+'%') OR PESQUISA IS NULL)
		AND 
			status=1
		AND
			idOrganizacao = ID_ORGANIZACAO;
            
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_MANTER_FORNECEDORES`(
	
    ID_ORGANIZACAO INT,
    ID_FORNECEDOR INT,
    STATUS_ BIT,
    PESQUISA VARCHAR(50),
	NOME_  VARCHAR(50),
	CNPJ_  VARCHAR(20),
	TELEFONE_  VARCHAR(20),
	EMAIL_  VARCHAR(50),
	CEP_  VARCHAR(10),
	ENDERECO_  VARCHAR(50),
	NUMERO_  INT,
	COMPLEMENTO_  VARCHAR(50),
	BAIRRO_  VARCHAR(50),
	CIDADE_  VARCHAR(50),
	ESTADO_  VARCHAR(50),
    ID_PARAMETRO_CONSULTA INT 	
)
BEGIN
	
	IF(ID_PARAMETRO_CONSULTA = 0)
	THEN

		INSERT INTO `fornecedor`
		(
			`idOrganizacao`,
			`nome`,
			`cnpj`,
			`telefone`,
			`email`,
			`cep`,
			`endereco`,
			`numero`,
			`complemento`,
			`bairro`,
			`cidade`,
			`estado`,
			`status`,
			`CadastroDataHora`,
			`CadastroUsuarioId`,
			`AtualizacaoDataHora`,
			`AtualizacaoUsuarioId`
		)
		VALUES
		(
			ID_ORGANIZACAO,
			NOME_,
			CNPJ_,
			TELEFONE_,
			EMAIL_,
			CEP_,
			ENDERECO_,
			NUMERO_,
			COMPLEMENTO_,
			BAIRRO_,
			CIDADE_,
			ESTADO_,
			1,
			current_timestamp(),
			NULL,
			NULL,
			NULL
        );

	ELSEIF(ID_PARAMETRO_CONSULTA = 1)
    THEN
		UPDATE 
			`fornecedor`
		SET
			`nome` = NOME_,
			`cnpj` = CNPJ_,
			`telefone` = TELEFONE_,
			`email` = EMAIL_,
			`cep` = CEP_,
			`endereco` = ENDERECO_,
			`numero` = NUMERO_,
			`complemento` = COMPLEMENTO_,
			`bairro` = BAIRRO_,
			`cidade` = CIDADE_,
			`estado` = ESTADO_,
			`status` = 1,
			`AtualizacaoDataHora` = current_timestamp()
		WHERE 
			`idFornecedor` = ID_FORNECEDOR
		AND
			`idOrganizacao` = ID_ORGANIZACAO;

	ELSEIF(ID_PARAMETRO_CONSULTA = 2)
    THEN
		UPDATE 
			`fornecedor`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp()
		WHERE 
			`idFornecedor` = ID_FORNECEDOR
		AND
			`idOrganizacao` = ID_ORGANIZACAO;

	ELSEIF(ID_PARAMETRO_CONSULTA = 3)
    THEN
		SELECT 
			idFornecedor
		,	idOrganizacao
		,	nome
		,	cnpj
		,	telefone
		,	email
		,	cep
		,	endereco
		,	numero
		,	complemento
		,	bairro
		,	cidade
		,	estado
		,	status
		,	CadastroDataHora
		,	CadastroUsuarioId
		,	AtualizacaoDataHora
		,	AtualizacaoUsuarioId
		from 
			fornecedor 
		where 
			(nome LIKE CONCAT('%'+PESQUISA+'%') OR PESQUISA IS NULL)
		AND
			(telefone LIKE CONCAT('%'+PESQUISA+'%') OR PESQUISA IS NULL)
		AND
			(cnpj  LIKE CONCAT('%'+PESQUISA+'%') OR PESQUISA IS NULL)
		AND
			(idfornecedor LIKE ('%'+PESQUISA+'%') OR PESQUISA IS NULL)
		and 
			status=1 
		and 
			idOrganizacao = ID_ORGANIZACAO;
           
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_MANTER_ORGANIZACAO`(
	NOME VARCHAR(30),
	ESTATUS  BIT,
    CNPJ VARCHAR(20),
    TELEFONE VARCHAR(20),
    EMAIL VARCHAR(50),
    CEP VARCHAR(20),
    COMPLEMENTO VARCHAR(50),
    ID_PARAMETRO_CONSULTA INT,
 	PESQUISA VARCHAR(30)
)
BEGIN
	
	IF(ID_PARAMETRO_CONSULTA = 0)
	THEN

		INSERT INTO organizacao
		(
			`nome`,
			`status`,
			`CadastroDataHora`,
			`CadastroUsuarioId`,
			`AtualizacaoDataHora`,
			`AtualizacaoUsuarioId`,
			`Cnpj`,
			`Telefone`,
			`Email`,
			`Cep`,
			`Comeplemento`

		)
		VALUES
		(
			NOME,
			1,
			current_timestamp(),
			NULL,
			NULL,
			NULL,
			CNPJ,
			TELEFONE,
			EMAIL,
			CEP,
			COMPLEMENTO
        );

	ELSEIF(ID_PARAMETRO_CONSULTA = 1)
    THEN
		UPDATE 
			`organizacao`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp(),
			`Cnpj` = CNPJ,
			`Telefone` = TELEFONE,
			`Email` = Email,
			`Cep` = CEP,
			`Comeplemento` = COMPLEMENTO
		WHERE 
			`Cnpj` = CNPJ
		AND
			`nome`= NOME;
            
	ELSEIF(ID_PARAMETRO_CONSULTA = 2)
    THEN
		UPDATE 
			`categoria`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = CURRENT_TIMESTAMP()
		WHERE 
			`Cnpj` = CNPJ
		AND
			`nome`= NOME;
	
    ELSEIF(ID_PARAMETRO_CONSULTA = 3)
    THEN
		SELECT 
				idOrganizacao
			,	nome
			,	status
			,	Cnpj
			,	Telefone
			,	Email
			,	Cep
			,	Complemento

		FROM 
			organizacao 
		WHERE
			(PESQUISA = CNPJ OR CNPJ IS NULL)
            AND
            (nome LIKE CONCAT('%', PESQUISA, '%') OR PESQUISA IS NULL);
		-- AND 
		-- 	status=1
		-- AND
		-- 	idOrganizacao = ID_ORGANIZACAO;
            
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_MANTER_PRODUTOS`(
	NOME_ VARCHAR(30),
    ID_ORGANIZACAO INT,
    ID_CATEGORIA INT,
    STATUS_ BIT,
    ID_PRODUTO INT,
    VALOR_VENDA DECIMAL(10,2),
    CODIGO_BARRAS VARCHAR(20),
    PESQUISA VARCHAR(50),
    ID_PARAMETRO_CONSULTA INT 	
)
BEGIN
	
	IF(ID_PARAMETRO_CONSULTA = 0)
	THEN

		INSERT INTO `produto`
		(
			`idOrganizacao`,
			`idCategoria`,
			`nome`,
			`valorVenda`,
			`status`,
			`CadastroDataHora`,
			`CadastroUsuarioId`,
			`AtualizacaoDataHora`,
			`AtualizacaoUsuarioId`,
			`CodigoDeBarras`
        )
		VALUES
		(
			ID_ORGANIZACAO,
			ID_CATEGORIA,
			NOME_,
			VALOR_VENDA,
			1,
			CURRENT_TIMESTAMP(),
			NULL,
			NULL,
			NULL,
			CODIGO_BARRAS
        );


	ELSEIF(ID_PARAMETRO_CONSULTA = 1)
    THEN
		UPDATE 
			`produto`
		SET
			`idCategoria` = ID_CATEGORIA,
			`nome` = NOME_,
			`valorVenda` = VALOR_VENDA,
			`status` = STATUS_,
			`AtualizacaoDataHora` = CURRENT_TIMESTAMP()
		WHERE 
			`idProduto` =ID_PRODUTO
		AND
			`idOrganizacao` = ID_ORGANIZACAO;

	ELSEIF(ID_PARAMETRO_CONSULTA = 2)
    THEN
		UPDATE 
			`produto`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = CURRENT_TIMESTAMP()
		WHERE 
			`idProduto` =ID_PRODUTO
		AND
			`idOrganizacao` = ID_ORGANIZACAO;

	ELSEIF(ID_PARAMETRO_CONSULTA = 3)
    THEN
		SELECT 
				p.idProduto AS ID_PRODUTO
			,	p.nome AS NOME 
			, 	p.valorVenda AS VALOR_VENDA 
			, 	p.idCategoria AS ID_CATEGORIA
			, 	c.nomeCategoria AS NOME_CATEGORIA
        FROM 
			produto p
		INNER JOIN 
			categoria c 
		ON 
			c.idCategoria = p.idCategoria
		WHERE 
		       (p.nome LIKE CONCAT('%','',PESQUISA,'','%'));
		-- and 
		--	p.status=1 
		-- and 
		-- 	p.idOrganizacao = ID_ORGANIZACAO
		-- and 
		-- 	c.status=1 
		-- and 
		--	c.idOrganizacao = ID_ORGANIZACAO;
            
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_MANTER_USUARIOS`(
	NOME_ VARCHAR(30),
    ID_ORGANIZACAO INT,
    ID_DEPARTAMENTO INT,
    STATUS_ BIT,
    PESQUISA VARCHAR(50),
    CPF VARCHAR(20),
    DATA_NASC DATETIME,
    TELEFONE VARCHAR(20),
    CELULAR VARCHAR(20),
    EMAIL VARCHAR(50),
    CEP VARCHAR(12),
    ENDERECO VARCHAR(100),
    NUMERO VARCHAR(20),
    COMPLEMENT0 VARCHAR(20),	
    ID_USUARIO INT,
    LOGIN VARCHAR(15),
    SENHA VARCHAR(15),
    ID_PARAMETRO_CONSULTA INT 	
)
BEGIN
	
	IF(ID_PARAMETRO_CONSULTA = 0)
	THEN
		INSERT INTO `usuarios`
		(
			`idOrganizacao`,
            `idDepartamento`,
			`nome`,
			`cpf`,
			`data_nascimento`,
			`telefone`,
			`celular`,
			`email`,
			`cep`,
            `complemento`,
            `numero`,
			`status`,
			`CadastroDataHora`,
			`CadastroUsuarioId`,
			`AtualizacaoDataHora`,
			`AtualizacaoUsuarioId`,
            `login`,
            `senha`
		)
        VALUES
		(
			ID_ORGANIZACAO,
            ID_DEPARTAMENTO,
			NOME,
			CPF,
			DATA_NASC,
			TELEFONE,
			CELULAR,
			EMAIL,
			CEP,
            COMPLEMENTO,
            NUMERO,
			1,
			current_timestamp(),
			ID_USUARIO,
			NULL,
			NULL,
            LOGIN,
            SENHA
        );

	ELSEIF(ID_PARAMETRO_CONSULTA = 1)
    THEN
		UPDATE 
			usuarios
		SET
			`telefone` = TELEFONE,
			`celular` = CELULAR,
            `idDepartamento` = ID_DEPARTAMENTO,
			`email` = EMAIL,
			`cep` =  CEP,
            `numero` =  NUMERO,
            `complemento` = COMPLEMENTO,
			`AtualizacaoDataHora` = current_timestamp(),
			`AtualizacaoUsuarioId` = ID_USUARIO
		WHERE 
			`idUsuario` = ID_USUARIO
		AND
			`idOrganizacao`= ID_ORGANIZACAO;
            
	ELSEIF(ID_PARAMETRO_CONSULTA = 2)
    THEN
		UPDATE 
			usuarios
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp(),
            `AtualizacaoUsuarioId` = ID_USUARIO
		WHERE 
			`idUsuario` = ID_USUARIO
		AND
			`idOrganizacao`= ID_ORGANIZACAO;
	
    ELSEIF(ID_PARAMETRO_CONSULTA = 3)
    THEN
		SELECT 
				nome
            ,	idUsuario
			,	idOrganizacao
            ,	idDepartamento
			,	nome
			,	cpf
			,	data_nascimento
			,	telefone
			,	celular
			,	email
			,	cep
			,	numero
			,	complemento
			,	status
			,	CadastroDataHora
			,	CadastroUsuarioId
			,	AtualizacaoDataHora
			,	AtualizacaoUsuarioId
		FROM 
			usuarios 
		WHERE
			(idUsuario= ID_USUARIO OR ID_USUARIO IS NULL)
            AND
            (
				(nome LIKE ('%'+PESQUISA+'%') OR PESQUISA IS NULL)
                OR
                (telefone LIKE ('%'+PESQUISA+'%') OR PESQUISA IS NULL)
			)
		AND 
			status=1
		AND
			idOrganizacao = ID_ORGANIZACAO;
            
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_SEL_LOGIN`(
	LOGIN_ VARCHAR(200),
	SENHA_ VARCHAR(200)
)
BEGIN
	 
	 IF (EXISTS(SELECT * FROM usuarios WHERE login = LOGIN_ AND senha = SENHA_))
	THEN                  
		-- RETORNA OS DADOS DO USUÁRIO
		SELECT 
				@USUARIO_ID := usu.idUsuario
			, 	@NOME_USU := usu.nome  
			,	@ORGANIZACAO_ID := org.idOrganizacao
			,	@NOME_ORG := org.nome AS nomeOrganizacao
			,	@PERMISSAO := usu.permissao AS permissao
		FROM 
			usuarios AS usu
			INNER JOIN organizacao AS org ON org.idOrganizacao = usu.idOrganizacao
		WHERE 
			login = LOGIN_ AND senha = SENHA_;
			
/*	INSERT INTO LogAcessosUsuarios
		(	
			IdUsuario
		)
		VALUES
		(
			@USUARIO_ID
		); */
		
		SELECT 
				@USUARIO_ID AS idUsuario
			,	@NOME_USU as nome
			,	@ORGANIZACAO_ID as idOrganizacao
			,	@NOME_ORG as nomeOrganizacao
			,	@PERMISSAO as permissao
		FROM DUAL;
			
	ELSE
		-- RETORNA ZERO CASO HAJA MAIS DE UMA CONTA COM O MESMO EMAIL
		SELECT 0;
	END IF;  
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_SEL_VALIDA_TOKEN`(
	TOKEN_ VARCHAR(500)
)
BEGIN       
        
     -- VERIFICA SE O TOKN EXISTE, SE EXISTIR RETORNA AS INFORMAÇOES DO USUÁRIO 
    IF(exists(SELECT * FROM usuarios WHERE TOKEN = TOKEN_ and FlagAtivacaoToken=0))
    THEN
	-- MARCA TOKEN UTILIZADO
		update
			usuarios
		SET
			FlagAtivacaoToken =1
		where
			Token = TOKEN_;
			
		SELECT 
				USU.idUsuario AS codUsuario
            ,	USU.nome AS nome
            ,	USU.permissao AS permissao
            ,	USU.idOrganizacao AS idOrganizacao
            ,	ORG.nome AS nomeOrganizacao
		FROM
			usuarios AS USU
		INNER JOIN
			organizacao AS ORG
		ON
			ORG.idOrganizacao = USU.idOrganizacao
		WHERE
			USU.Token= TOKEN_
		AND
			usu.DataValidadeToken >= current_timestamp()
		AND
			USU.status=1
		AND
			ORG.status=1;
            
		
	else
		SELECT 0;
	end if;
        
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_UPD_ESQUECI_MINHA_SENHA`(
	EMAIL_ VARCHAR(30)
)
BEGIN       
	-- VARIÁVEIS 
    DECLARE IdUsuarioAux INT;
    DECLARE COUNT_ INT;
	DECLARE NOVASENHA INT;
         
     -- RETORNA NUMERO DE CONTAS COM O MESMO EMAIL
    SELECT COUNT(*) INTO COUNT_ FROM usuarios WHERE login = EMAIL_;
	
    -- VERIFICA SE TEM MAIS DE UMA CONTA COM O MESMO EMAIL
    IF (COUNT_ = 1)
    THEN
		-- SELECIONA O ID DO USUÁRIO
		SELECT idUsuario INTO IdUsuarioAux FROM usuarios WHERE login = EMAIL_;
		-- GERA UMA SENHA 
		SELECT (FLOOR(RAND() * 1000000)) INTO NOVASENHA FROM DUAL;
        
		-- ATUALIZA COM A NOVA SENHA
		UPDATE
			usuarios
		SET
			SENHA = MD5(NOVASENHA)
		WHERE
			idUsuario = IdUsuarioAux;	
          
		-- RETORNA OS DADOS DO USUÁRIO
		SELECT 
				NOVASENHA as senha
			, 	usu.login as login 
            ,	org.nome as organizacao
            ,	usu.email as email
            ,	usu.nome as nome
        FROM 
			usuarios as usu
		INNER JOIN
			organizacao as org
		on
			org.idOrganizacao = usu.idOrganizacao
		WHERE 
			idUsuario = idUsuarioAux;
    else
		-- RETORNA ZERO CASO HAJA MAIS DE UMA CONTA COM O MESMO EMAIL
        SELECT 0;
	end if;     
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
`idCategoria` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `nomeCategoria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `idOrganizacao`, `nomeCategoria`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(12, 1, 'Doces', b'1', '2016-06-01 14:51:55', NULL, NULL, NULL),
(13, 1, 'Salgados', b'1', '2016-06-15 21:02:31', NULL, NULL, NULL),
(14, 1, 'Pães', b'1', '2016-06-15 21:43:52', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
`idCliente` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `complemento` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uf` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`idCliente`, `idOrganizacao`, `nome`, `cpf`, `data_nascimento`, `telefone`, `celular`, `email`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(1, 1, 'nome', 'cpf', '2011-01-01', 'tel', 'cel', 'email', 'cep', 'end', 'n', '', 'bairro', 'cid', 'uf', b'1', '2016-01-07 03:13:26', 2, NULL, NULL),
(2, 1, 'Carlos', '1132', '0000-00-00', '123435', '43321', 'car@los.com', '1213', 'xxx', '12', 'xxx', 'xx', 'xx', 'xx', b'1', '2016-06-06 16:21:30', 1, NULL, NULL),
(3, 1, 'Kevin', '1111', '0000-00-00', '111', '112222', 'xxx', '1212', 'xx', 'xx', 'xx', 'xxx', 'xx', 'xx', b'1', '2016-06-06 16:44:12', 1, NULL, NULL),
(4, 1, 'Antonio', '111111', '0000-00-00', 'aaaaa', 'a', 'aaaaaa', 'a', 'aaa', 'aaa', 'aa', 'aa', 'aaaa', 'a', b'1', '2016-06-06 16:46:18', 1, NULL, NULL),
(9, 1, 'b', 'b', '2016-06-09', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', b'1', '2016-06-06 18:30:07', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE IF NOT EXISTS `conta` (
`idConta` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `saldoConta` decimal(10,2) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `controle_menu`
--

CREATE TABLE IF NOT EXISTS `controle_menu` (
`idControlemenu` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `CadastroDataHora` datetime DEFAULT NULL,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `controle_menu`
--

INSERT INTO `controle_menu` (`idControlemenu`, `idUsuario`, `idMenu`, `idOrganizacao`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(221, 2, 7, 1, NULL, NULL, NULL, NULL),
(222, 2, 2, 1, NULL, NULL, NULL, NULL),
(223, 2, 6, 1, NULL, NULL, NULL, NULL),
(224, 2, 5, 1, NULL, NULL, NULL, NULL),
(225, 2, 9, 1, NULL, NULL, NULL, NULL),
(226, 227, 2, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(227, 227, 4, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(228, 227, 5, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(229, 227, 6, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(230, 227, 7, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(231, 227, 8, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(232, 227, 9, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(233, 254, 2, 1, NULL, NULL, NULL, NULL),
(234, 254, 6, 1, NULL, NULL, NULL, NULL),
(235, 255, 2, 1, NULL, NULL, NULL, NULL),
(236, 255, 6, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `controle_submenu`
--

CREATE TABLE IF NOT EXISTS `controle_submenu` (
`idControleSubMenu` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idSubMenu` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=437 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `controle_submenu`
--

INSERT INTO `controle_submenu` (`idControleSubMenu`, `idUsuario`, `idSubMenu`, `idOrganizacao`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(406, 2, 1, 1, NULL, NULL, NULL, NULL),
(407, 2, 2, 1, NULL, NULL, NULL, NULL),
(408, 2, 3, 1, NULL, NULL, NULL, NULL),
(409, 2, 4, 1, NULL, NULL, NULL, NULL),
(410, 2, 6, 1, NULL, NULL, NULL, NULL),
(411, 2, 9, 1, NULL, NULL, NULL, NULL),
(412, 2, 7, 1, NULL, NULL, NULL, NULL),
(413, 2, 8, 1, NULL, NULL, NULL, NULL),
(414, 2, 10, 1, NULL, NULL, NULL, NULL),
(415, 2, 11, 1, NULL, NULL, NULL, NULL),
(416, 2, 12, 1, NULL, NULL, NULL, NULL),
(417, 2, 13, 1, NULL, NULL, NULL, NULL),
(418, 2, 14, 1, NULL, NULL, NULL, NULL),
(419, 2, 15, 1, NULL, NULL, NULL, NULL),
(420, 227, 1, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(421, 227, 2, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(422, 227, 3, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(423, 227, 4, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(424, 227, 5, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(425, 227, 6, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(426, 227, 7, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(427, 227, 8, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(428, 227, 9, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(429, 227, 10, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(430, 227, 11, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(431, 227, 12, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(432, 227, 13, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(433, 227, 14, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(434, 227, 15, 210, '2016-01-06 16:03:18', NULL, NULL, NULL),
(435, 254, 9, 1, '2016-06-13 23:23:59', NULL, NULL, NULL),
(436, 255, 9, 1, '2016-06-13 23:27:15', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamento`
--

CREATE TABLE IF NOT EXISTS `departamento` (
`idDepartamento` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `departamento`
--

INSERT INTO `departamento` (`idDepartamento`, `idOrganizacao`, `nome`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(1, 3, 'Comercial', b'1', NULL, NULL, NULL, NULL),
(2, 3, 'Outsourcing', b'1', NULL, NULL, NULL, NULL),
(3, 1, 'Soluções', b'1', NULL, NULL, NULL, NULL),
(4, 3, 'Infraestrutura', b'1', NULL, NULL, NULL, NULL),
(5, 3, 'RH', b'1', NULL, NULL, NULL, NULL),
(6, 3, 'Vendas', b'1', NULL, NULL, NULL, NULL),
(7, 1, 'Comercial', b'1', NULL, NULL, NULL, NULL),
(8, 1, 'Outsourcing', b'1', NULL, NULL, NULL, NULL),
(9, 1, 'Soluções', b'1', NULL, NULL, NULL, NULL),
(10, 1, 'RH', b'1', NULL, NULL, NULL, NULL),
(11, 1, 'infraestrutura', b'1', NULL, NULL, NULL, NULL),
(12, 2, 'Comercial', b'1', NULL, NULL, NULL, NULL),
(13, 2, 'Outsourcing', b'1', NULL, NULL, NULL, NULL),
(14, 2, 'Soluções', b'1', NULL, NULL, NULL, NULL),
(15, 2, 'RH', b'1', NULL, NULL, NULL, NULL),
(16, 2, 'infraestrutura', b'1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE IF NOT EXISTS `fornecedor` (
`idFornecedor` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnpj` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `complemento` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `status` bit(1) NOT NULL,
  `CadastroDataHora` datetime DEFAULT NULL,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`idFornecedor`, `idOrganizacao`, `nome`, `cnpj`, `telefone`, `email`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(1, 210, 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', b'1', '2016-01-07 05:47:54', 227, NULL, NULL),
(2, 1, 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', b'1', '2016-01-09 14:01:22', 2, NULL, NULL),
(3, 1, 'Doceria São João', '121132323', '43232143', 'sac@saojoao.com', '123', 'Rua dos Palmares', '23', '', 'São Mateus', 'São Paulo', 'SP', b'1', NULL, NULL, NULL, NULL),
(4, 1, 'Bombril', '34576', '12243', 'sac@bombril.com', '1212312', 'Rua Sol', '12', '', 'Santa Adélia', 'São Paulo', 'SP', b'1', NULL, NULL, NULL, NULL),
(5, 1, 'São Sergio', '77.628.339/', '99919991', 'sac@saosergio.com.br', '098', 'Rua dos Palmares', '21', '', 'São Mateus', 'São Paulo', 'SP', b'1', NULL, NULL, NULL, NULL),
(6, 1, 'José', '1213', '123', 'ze@ze.com', '123', 'rua xxx', '123', '', 'São Mateus', 'São Paulo', 'Sp', b'1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_venda`
--

CREATE TABLE IF NOT EXISTS `item_venda` (
`idItem` int(11) NOT NULL,
  `idVenda` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `qtde` int(11) NOT NULL DEFAULT '1',
  `subTotal` float NOT NULL,
  `cancelado` bit(1) NOT NULL COMMENT 'se for 1 é cancelado',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `item_venda`
--

INSERT INTO `item_venda` (`idItem`, `idVenda`, `idProduto`, `qtde`, `subTotal`, `cancelado`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(12, 12, 17, 1, 5, b'0', '2016-06-01 14:54:47', NULL, NULL, NULL),
(13, 13, 17, 1, 5, b'0', '2016-06-01 17:01:58', NULL, NULL, NULL),
(14, 13, 17, 4, 20, b'0', '2016-06-01 17:01:58', NULL, NULL, NULL),
(15, 14, 17, 1, 5, b'0', '2016-06-01 19:36:53', NULL, NULL, NULL),
(16, 15, 17, 1, 5, b'0', '2016-06-01 19:45:18', NULL, NULL, NULL),
(17, 17, 18, 1, 2, b'0', '2016-06-01 19:46:23', NULL, NULL, NULL),
(18, 18, 17, 1, 5, b'0', '2016-06-01 19:52:26', NULL, NULL, NULL),
(19, 19, 20, 1, 3, b'0', '2016-06-01 20:02:49', NULL, NULL, NULL),
(20, 20, 21, 1, 2, b'0', '2016-06-01 20:22:28', NULL, NULL, NULL),
(21, 21, 21, 1, 2, b'0', '2016-06-01 20:25:51', NULL, NULL, NULL),
(22, 22, 21, 1, 2, b'0', '2016-06-01 20:26:25', NULL, NULL, NULL),
(23, 22, 21, 199, 398, b'0', '2016-06-01 20:26:25', NULL, NULL, NULL),
(24, 23, 17, 1, 5, b'0', '2016-06-03 00:42:47', NULL, NULL, NULL),
(25, 24, 17, 1, 5, b'0', '2016-06-04 15:18:46', NULL, NULL, NULL),
(26, 25, 17, 1, 5, b'0', '2016-06-04 15:19:30', NULL, NULL, NULL),
(27, 26, 17, 1, 5, b'0', '2016-06-04 15:19:54', NULL, NULL, NULL),
(28, 26, 18, 1, 2, b'0', '2016-06-04 15:19:54', NULL, NULL, NULL),
(29, 27, 17, 1, 5, b'0', '2016-06-04 17:03:35', NULL, NULL, NULL),
(30, 29, 18, 1, 2, b'0', '2016-06-05 21:15:48', NULL, NULL, NULL),
(31, 29, 17, 10, 50, b'0', '2016-06-05 21:15:48', NULL, NULL, NULL),
(32, 30, 19, 1, 2, b'0', '2016-06-05 22:08:19', NULL, NULL, NULL),
(33, 30, 20, 20, 60, b'0', '2016-06-05 22:08:19', NULL, NULL, NULL),
(34, 31, 17, 1, 5, b'0', '2016-06-06 10:38:47', NULL, NULL, NULL),
(35, 31, 19, 1, 2, b'0', '2016-06-06 10:38:47', NULL, NULL, NULL),
(36, 32, 18, 1, 2, b'0', '2016-06-06 10:40:52', NULL, NULL, NULL),
(37, 33, 21, 1, 2, b'0', '2016-06-07 12:40:02', NULL, NULL, NULL),
(38, 33, 18, 1, 2, b'0', '2016-06-07 12:40:03', NULL, NULL, NULL),
(39, 34, 17, 1, 5, b'0', '2016-06-07 15:03:29', NULL, NULL, NULL),
(40, 35, 17, 1, 5, b'0', '2016-06-07 15:04:04', NULL, NULL, NULL),
(41, 36, 17, 1, 5, b'0', '2016-06-07 15:06:36', NULL, NULL, NULL),
(42, 37, 20, 900, 2700, b'0', '2016-06-08 07:36:08', NULL, NULL, NULL),
(43, 38, 20, 900, 2700, b'0', '2016-06-08 07:48:28', NULL, NULL, NULL),
(44, 39, 17, 1, 5, b'0', '2016-06-08 07:52:05', NULL, NULL, NULL),
(45, 40, 17, 1, 5, b'0', '2016-06-08 07:56:18', NULL, NULL, NULL),
(46, 41, 17, 1, 5, b'0', '2016-06-08 08:00:19', NULL, NULL, NULL),
(47, 42, 17, 1, 5, b'0', '2016-06-08 11:19:53', NULL, NULL, NULL),
(49, 59, 17, 1, 5, b'0', '2016-06-15 13:00:36', NULL, NULL, NULL),
(50, 60, 21, 1, 2, b'0', '2016-06-15 13:02:05', NULL, NULL, NULL),
(51, 61, 19, 1, 2, b'0', '2016-06-15 13:03:12', NULL, NULL, NULL),
(52, 62, 21, 1, 2, b'0', '2016-06-15 13:42:56', NULL, NULL, NULL),
(53, 63, 21, 1, 2, b'0', '2016-06-15 13:43:22', NULL, NULL, NULL),
(54, 64, 21, 1, 2, b'0', '2016-06-15 13:43:43', NULL, NULL, NULL),
(55, 65, 18, 2, 4, b'0', '2016-06-15 14:20:10', NULL, NULL, NULL),
(56, 67, 18, 1, 2, b'0', '2016-06-15 17:45:15', NULL, NULL, NULL),
(57, 68, 18, 1, 2, b'0', '2016-06-15 17:45:48', NULL, NULL, NULL),
(58, 69, 23, 2, 4, b'0', '2016-06-15 21:48:24', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `logacessosusuarios`
--

CREATE TABLE IF NOT EXISTS `logacessosusuarios` (
`LogAcessoUsuarioId` int(11) NOT NULL,
  `UsuarioId` int(11) NOT NULL,
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `logacessosusuarios`
--

INSERT INTO `logacessosusuarios` (`LogAcessoUsuarioId`, `UsuarioId`, `CadastroDataHora`) VALUES
(20, 2, '2016-01-07 11:37:44'),
(19, 2, '2016-01-07 11:04:33'),
(18, 227, '2016-01-07 10:31:56'),
(17, 227, '2016-01-07 10:19:20'),
(16, 227, '2016-01-07 10:15:32'),
(15, 227, '2016-01-07 10:13:23'),
(14, 227, '2016-01-07 05:47:11'),
(13, 227, '2016-01-07 05:43:02'),
(12, 227, '2016-01-07 05:36:07'),
(11, 227, '2016-01-07 05:29:23'),
(21, 227, '2016-01-07 14:14:39'),
(22, 227, '2016-01-08 10:18:28'),
(23, 227, '2016-01-08 15:35:05'),
(24, 2, '2016-01-09 13:57:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loteprodutos`
--

CREATE TABLE IF NOT EXISTS `loteprodutos` (
`idLote` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `idFornecedor` int(11) NOT NULL,
  `valorCompra` float NOT NULL,
  `qtde` int(11) NOT NULL,
  `validade` date NOT NULL,
  `data` date NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `CadastroDataHora` datetime DEFAULT NULL,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `loteprodutos`
--

INSERT INTO `loteprodutos` (`idLote`, `idOrganizacao`, `idProduto`, `idFornecedor`, `valorCompra`, `qtde`, `validade`, `data`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(32, 1, 18, 3, 1, 500, '2016-06-30', '2016-06-15', b'1', NULL, NULL, NULL, NULL),
(34, 1, 23, 6, 5, 1000, '2016-06-18', '2016-06-15', b'1', NULL, NULL, NULL, NULL),
(29, 1, 17, 5, 1, 200, '2016-06-28', '2016-06-12', b'1', NULL, NULL, NULL, NULL),
(33, 1, 19, 3, 1, 1000, '2016-06-30', '2016-06-15', b'1', NULL, NULL, NULL, NULL),
(31, 1, 19, 5, 1, 500, '2016-06-23', '2016-06-15', b'1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loteprodutosbaixa`
--

CREATE TABLE IF NOT EXISTS `loteprodutosbaixa` (
`LoteProdutoBaixaId` int(11) NOT NULL,
  `LoteProdutosId` int(11) DEFAULT NULL,
  `Quantidade` int(11) NOT NULL DEFAULT '0',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `FlagStatus` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loteprodutosbaixa`
--

INSERT INTO `loteprodutosbaixa` (`LoteProdutoBaixaId`, `LoteProdutosId`, `Quantidade`, `CadastroDataHora`, `CadastroUsuarioId`, `FlagStatus`) VALUES
(30, 29, 200, '2016-06-15 00:00:00', 2, b'1'),
(32, 31, 497, '2016-06-15 00:00:00', 2, b'1'),
(33, 32, 496, '2016-06-15 00:00:00', 2, b'1'),
(34, 33, 1000, '2016-06-15 00:00:00', 2, b'1'),
(35, 33, 1000, '2016-06-15 00:00:00', 2, b'1'),
(36, 34, 998, '2016-06-15 00:00:00', 2, b'1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`idMenu` int(11) NOT NULL,
  `nome` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `link` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `status` int(11) NOT NULL,
  `CadastroDataHora` datetime DEFAULT NULL,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`idMenu`, `nome`, `link`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(2, 'Caixa', 'caixa.html', 1, NULL, NULL, NULL, NULL),
(5, 'Relatórios', '', 1, NULL, NULL, NULL, NULL),
(6, 'Despesas', '', 1, NULL, NULL, NULL, NULL),
(7, 'Cadastros', '', 1, NULL, NULL, NULL, NULL),
(8, 'Contate o desenvolvedor', '', 0, NULL, NULL, NULL, NULL),
(9, 'Visualizar', '', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `organizacao`
--

CREATE TABLE IF NOT EXISTS `organizacao` (
`idOrganizacao` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL,
  `Cnpj` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Cep` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Complemento` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=225 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `organizacao`
--

INSERT INTO `organizacao` (`idOrganizacao`, `nome`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`, `Cnpj`, `Telefone`, `Email`, `Cep`, `Complemento`) VALUES
(1, 'Processor', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'IBM', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Microsoft', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 'Gipentec', 1, '2016-01-06 16:03:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 'São Sergio', 1, '2016-06-05 13:51:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 'São Sergio', 1, '2016-06-05 14:43:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 'z', 1, '2016-06-05 17:09:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(217, 'a', 1, '2016-06-05 18:43:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 'a', 1, '2016-06-05 18:44:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(219, '', 1, '2016-06-05 19:59:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, '', 1, '2016-06-05 20:00:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, '', 1, '2016-06-05 20:05:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(222, '', 1, '2016-06-05 20:05:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, '', 1, '2016-06-05 20:08:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, '', 1, '2016-06-05 20:11:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE IF NOT EXISTS `pagamento` (
`idPagamento` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `valor` float NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `CadastroDataHora` datetime DEFAULT NULL,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perdas`
--

CREATE TABLE IF NOT EXISTS `perdas` (
`idPerda` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `idLote` int(11) NOT NULL,
  `qtde` int(11) NOT NULL,
  `dataPerda` date NOT NULL,
  `motivoPerda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CadastroDataHora` datetime DEFAULT NULL,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

CREATE TABLE IF NOT EXISTS `permissoes` (
`idPermissao` int(11) NOT NULL,
  `nome` varchar(150) COLLATE utf8_unicode_ci DEFAULT '',
  `ativo` bit(1) DEFAULT b'1',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`idPermissao`, `nome`, `ativo`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(1, 'Adm', b'1', NULL, NULL, NULL, NULL),
(2, 'User', b'1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
`idProduto` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `valorVenda` float NOT NULL,
  `status` bit(1) NOT NULL,
  `CadastroDataHora` datetime DEFAULT NULL,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL,
  `CodigoDeBarras` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`idProduto`, `idOrganizacao`, `idCategoria`, `nome`, `valorVenda`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`, `CodigoDeBarras`) VALUES
(17, 1, 12, 'Bolo', 5, b'1', '2016-06-01 14:52:23', NULL, NULL, NULL, '001'),
(18, 1, 12, 'KidKat', 2, b'1', '2016-06-01 19:43:36', NULL, NULL, NULL, '111'),
(19, 1, 12, 'Cocada', 2, b'1', '2016-06-01 19:59:21', NULL, NULL, NULL, '121'),
(20, 1, 12, 'Paçoca', 3, b'1', '2016-06-01 20:01:14', NULL, NULL, NULL, '122'),
(21, 1, 12, 'Pirulito', 2, b'1', '2016-06-01 20:15:17', NULL, NULL, NULL, '444'),
(22, 1, 12, 'teste', 122, b'1', '2016-06-12 00:04:14', NULL, NULL, NULL, '11234566'),
(23, 1, 14, 'Pão Doce', 2, b'1', '2016-06-15 21:45:23', NULL, NULL, NULL, '0156');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub_menu`
--

CREATE TABLE IF NOT EXISTS `sub_menu` (
`idSubMenu` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `link` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `status` int(11) NOT NULL,
  `CadastroDataHora` datetime DEFAULT NULL,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sub_menu`
--

INSERT INTO `sub_menu` (`idSubMenu`, `idMenu`, `nome`, `link`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(1, 7, 'Cadastro de Clientes', 'cadastro-de-clientes.html', 1, NULL, NULL, NULL, NULL),
(2, 7, 'Cadastro de Produtos', 'cadastro-de-produtos.html', 1, NULL, NULL, NULL, NULL),
(3, 7, 'Cadastro de Usuários', 'cadastro-de-usuarios.html', 1, NULL, NULL, NULL, NULL),
(4, 7, 'Cadastro de Fornecedores', 'cadastro-de-fornecedores.html', 1, NULL, NULL, NULL, NULL),
(5, 7, 'Cadastro de Serviços', 'cadastro-de-servicos.html', 1, NULL, NULL, NULL, NULL),
(6, 7, 'Cadastro de Categoria', 'cadastro-de-categorias.html', 1, NULL, NULL, NULL, NULL),
(7, 5, 'Relatório Diário', 'relatorio-diario.html', 1, NULL, NULL, NULL, NULL),
(8, 5, 'Relatório Semanal', 'relatorio-semanal.html', 1, NULL, NULL, NULL, NULL),
(9, 6, 'Compra de Produtos', 'compra-de-produtos.html', 1, NULL, NULL, NULL, NULL),
(10, 9, 'Clientes', 'listar-clientes.html', 1, NULL, NULL, NULL, NULL),
(11, 9, 'Usuários', 'listar-usuarios.html', 1, NULL, NULL, NULL, NULL),
(12, 9, 'Produtos', 'listar-produtos.html', 1, NULL, NULL, NULL, NULL),
(13, 9, 'Fornecedores', 'listar-fornecedores.html', 1, NULL, NULL, NULL, NULL),
(14, 9, 'Lotes', 'listar-lotes.html', 1, NULL, NULL, NULL, NULL),
(15, 9, 'Estoque', 'listar-estoque.html', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`idUsuario` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `idDepartamento` int(11) DEFAULT NULL,
  `nome` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `cpf` varchar(14) COLLATE utf8_unicode_ci DEFAULT '',
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `celular` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `cep` varchar(15) COLLATE utf8_unicode_ci DEFAULT '',
  `endereco` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `numero` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `complemento` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `bairro` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `cidade` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `estado` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `login` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `senha` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `permissao` int(11) DEFAULT '0',
  `status` bit(1) DEFAULT b'1',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL,
  `token` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DataValidadeToken` datetime DEFAULT NULL,
  `FlagAtivacaoToken` bit(1) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=256 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `idOrganizacao`, `idDepartamento`, `nome`, `cpf`, `data_nascimento`, `telefone`, `celular`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `email`, `login`, `senha`, `permissao`, `status`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`, `token`, `DataValidadeToken`, `FlagAtivacaoToken`) VALUES
(2, 1, 3, 'João Paulo', '37896155877', '1991-06-24', '23370426', '949096384', '04255001', 'rua sao joao climaco', '414', 'casa 3', 'sao joao climaco', 'sao paulo', 'sp', 'joaopaulo_391@hotmail.com', 'joao', '81dc9bdb52d04dc20036dbd8313ed055', 2, b'1', NULL, NULL, NULL, NULL, NULL, NULL, b'0'),
(22, 2, 12, 'Fernanda', '12312312311', '1111-12-11', '233165448', '999999999', '04209001', 'rua', '37', 'b', 'sao joao cliamco', 'sao paulo', 'sp', '@@@@@@', '698dc19d489c4e4db73e28a713eab07b', '81dc9bdb52d04dc20036dbd8313ed055', 2, b'1', NULL, NULL, NULL, NULL, NULL, NULL, b'0'),
(227, 210, NULL, 'Reginaldo', NULL, NULL, NULL, '', '', '', '', '', '', '', '', 'vendas@gipentec.com', 'vendas@gipentec.com', '81dc9bdb52d04dc20036dbd8313ed055', 2, b'1', '2016-01-06 16:03:18', NULL, NULL, NULL, '750f5194f676631f59dea593a50e59d9', '2016-01-13 16:03:18', NULL),
(228, 1, 0, 'a', 'aaaa', '0000-00-00', 'aaa', 'aaa', 'a', 'aaa', 'a', 'aaa', 'a', 'a', '', 'aaaaa', 'a', 'a', 0, b'1', '2016-06-02 18:49:02', 0, NULL, NULL, NULL, NULL, NULL),
(229, 1, 0, 'b', 'b', '0000-00-00', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', '', 'b', 'a6a3d9817913f318bf4f01d77a05d502', 'a6a3d9817913f318bf4f01d77a05d502', 0, b'1', '2016-06-02 18:50:48', 0, NULL, NULL, NULL, NULL, NULL),
(247, 1, 0, 'ze', '12313', '2016-06-14', '23123', '213213', '23213', '2313', '233', '3213', '3213', '231', '', '213213', '98b456a0723fa616284a632d9d31821b', '202cb962ac59075b964b07152d234b70', 0, b'1', '2016-06-06 19:14:41', 0, NULL, NULL, NULL, NULL, NULL),
(230, 1, 0, 'zeze', '1212', '0000-00-00', '1111', '44', '1234', 'xxx', '1212', 'xxx', 'xx', 'xx', '', 'zeze@ze.com', '5167356f3931609ba816f489f5131517', '202cb962ac59075b964b07152d234b70', 0, b'1', '2016-06-04 18:44:11', 0, NULL, NULL, NULL, NULL, NULL),
(231, 1, 0, 'xx', 'xx', '0000-00-00', 'xx', 'xx', 'xx', 'xx', 'xx', 'xx', 'xx', 'xx', '', 'xx', '9336ebf25087d91c818ee6e9ec29f8c1', '9336ebf25087d91c818ee6e9ec29f8c1', 2, b'0', '2016-06-04 18:44:45', 0, '2016-06-04 20:39:22', 231, NULL, NULL, NULL),
(239, 216, NULL, 'z', NULL, NULL, 'z', '', '', '', '', '', '', '', '', 'z', 'fbade9e36a3f36d3d676c1b808451dd7', 'd41d8cd98f00b204e9800998ecf8427e', 2, b'1', '2016-06-05 17:09:53', NULL, NULL, NULL, 'e5eaee43421f5ff669ca856533f5cac2', '2016-06-12 17:09:53', NULL),
(235, 212, NULL, 'Henrique', NULL, NULL, '123456', '', '', '', '', '', '', '', '', 'h1@gmail.com', 'h1@gmail.com', '202cb962ac59075b964b07152d234b70', 2, b'1', '2016-06-05 14:43:31', NULL, NULL, NULL, 'afc3e043fca515396038453275a6fed7', '2016-06-12 14:43:31', NULL),
(240, 218, NULL, 'a', NULL, NULL, 'a', '', '', '', '', '', '', '', '', 'a', '0cc175b9c0f1b6a831c399e269772661', 'd41d8cd98f00b204e9800998ecf8427e', 2, b'1', '2016-06-05 18:44:51', NULL, NULL, NULL, '3945d1d60616f10aa5f69eefa2ef08e9', '2016-06-12 18:44:51', NULL),
(252, 224, NULL, 'Moe', NULL, NULL, '1234', '', '', '', '', '', '', '', '', 'sac@moesbar.com', 'aef704a54fdf294eb79440aabd02b2d7', 'd41d8cd98f00b204e9800998ecf8427e', 2, b'1', '2016-06-06 19:58:04', NULL, NULL, NULL, '3959a373060151515e05594d4cbcd6b1', '2016-06-13 19:58:04', NULL),
(251, 224, NULL, 'Moe', NULL, NULL, '1234', '', '', '', '', '', '', '', '', 'moe@bar.com', 'a6d340ec408d2e2c71a1780e9bf90341', 'd41d8cd98f00b204e9800998ecf8427e', 2, b'1', '2016-06-06 19:56:49', NULL, NULL, NULL, '4ed0c71c1dbe4da847171ddf845bc103', '2016-06-13 19:56:49', NULL),
(250, 224, NULL, 'Moe', NULL, NULL, '1224', '', '', '', '', '', '', '', '', 'sac@moe.com', 'c937b3d5ec75163e9ece2403413f991a', 'd41d8cd98f00b204e9800998ecf8427e', 2, b'1', '2016-06-06 19:52:36', NULL, NULL, NULL, 'fd02b44798c647ef1a4963f4ea4599b9', '2016-06-13 19:52:36', NULL),
(248, 1, 0, 'p', 'p', '2016-06-22', 'p', 'p', 'p', 'p', 'p', 'p', 'p', 'p', '', 'p', 'p', '83878c91171338902e0fe0fb97a8c47a', 0, b'1', '2016-06-06 19:19:13', 0, NULL, NULL, NULL, NULL, NULL),
(249, 224, NULL, 'Moe', NULL, NULL, '1224', '', '', '', '', '', '', '', '', 'sac@moe.com', 'c937b3d5ec75163e9ece2403413f991a', 'd41d8cd98f00b204e9800998ecf8427e', 2, b'1', '2016-06-06 19:52:36', NULL, NULL, NULL, '9dfd5ed8e674be868004fd9c8ea65a44', '2016-06-13 19:52:36', NULL),
(253, 1, 7, 'joao2', '', '2016-06-01', '', '', 'joao2', 'joao2', '', 'joao2', 'joao2', 'joao2', '', 'joao2', 'joao2', '902fdff1dd0ab1bdb32e712f691d9b23', 0, b'1', '2016-06-13 23:11:49', 2, NULL, NULL, NULL, NULL, NULL),
(254, 1, 0, 'joaopaulo1', '', '2016-06-02', '', '', '', 'joaopaulo1', '', 'joaopaulo1', 'joaopaulo1', 'joaopaulo1', '', 'joaopaulo1', 'joaopaulo1', '8fe940255cea9c1a0daf50adecc0ef47', 0, b'1', '2016-06-13 23:23:59', 2, NULL, NULL, NULL, NULL, NULL),
(255, 1, 3, 'teste44', '', '0000-00-00', '', '', 'teste44', 'teste44teste44', 'teste44', 'teste44', 'teste44', 'teste44', '', '', 'teste44', 'd739197d00c6ebd85c1afd56693c1052', 0, b'1', '2016-06-13 23:27:15', 2, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE IF NOT EXISTS `venda` (
`idVenda` int(11) NOT NULL,
  `idOrganizacao` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL DEFAULT '0',
  `dataVenda` datetime DEFAULT CURRENT_TIMESTAMP,
  `horaVenda` time NOT NULL,
  `cancelado` bit(1) NOT NULL COMMENT 'se for 1 é cancelado',
  `CadastroDataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `CadastroUsuarioId` int(11) DEFAULT NULL,
  `AtualizacaoDataHora` datetime DEFAULT NULL,
  `AtualizacaoUsuarioId` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `venda`
--

INSERT INTO `venda` (`idVenda`, `idOrganizacao`, `idCliente`, `dataVenda`, `horaVenda`, `cancelado`, `CadastroDataHora`, `CadastroUsuarioId`, `AtualizacaoDataHora`, `AtualizacaoUsuarioId`) VALUES
(12, 1, 0, '2016-06-01 00:00:00', '14:54:47', b'0', '2016-06-01 14:54:47', NULL, NULL, NULL),
(13, 1, 0, '2016-06-01 00:00:00', '17:01:58', b'0', '2016-06-01 17:01:58', NULL, NULL, NULL),
(14, 1, 0, '2016-06-01 00:00:00', '19:36:53', b'0', '2016-06-01 19:36:53', NULL, NULL, NULL),
(15, 1, 0, '2016-06-01 00:00:00', '19:45:18', b'0', '2016-06-01 19:45:18', NULL, NULL, NULL),
(16, 1, 0, '2016-06-01 00:00:00', '19:46:16', b'1', '2016-06-01 19:46:16', NULL, NULL, NULL),
(17, 1, 0, '2016-06-01 00:00:00', '19:46:23', b'0', '2016-06-01 19:46:23', NULL, NULL, NULL),
(18, 1, 0, '2016-06-01 00:00:00', '19:52:26', b'0', '2016-06-01 19:52:26', NULL, NULL, NULL),
(19, 1, 0, '2016-06-01 00:00:00', '20:02:49', b'0', '2016-06-01 20:02:49', NULL, NULL, NULL),
(20, 1, 0, '2016-06-01 00:00:00', '20:22:28', b'0', '2016-06-01 20:22:28', NULL, NULL, NULL),
(21, 1, 0, '2016-06-01 00:00:00', '20:25:51', b'0', '2016-06-01 20:25:51', NULL, NULL, NULL),
(22, 1, 0, '2016-06-01 00:00:00', '20:26:25', b'0', '2016-06-01 20:26:25', NULL, NULL, NULL),
(23, 1, 0, '2016-06-03 00:00:00', '00:42:47', b'0', '2016-06-03 00:42:47', NULL, NULL, NULL),
(24, 1, 0, '2016-06-04 00:00:00', '15:18:46', b'0', '2016-06-04 15:18:46', NULL, NULL, NULL),
(25, 1, 0, '2016-06-04 00:00:00', '15:19:30', b'0', '2016-06-04 15:19:30', NULL, NULL, NULL),
(26, 1, 0, '2016-06-04 00:00:00', '15:19:54', b'0', '2016-06-04 15:19:54', NULL, NULL, NULL),
(27, 1, 0, '2016-06-04 00:00:00', '17:03:35', b'0', '2016-06-04 17:03:35', NULL, NULL, NULL),
(28, 1, 0, '2016-06-05 00:00:00', '21:15:22', b'1', '2016-06-05 21:15:22', NULL, NULL, NULL),
(29, 1, 0, '2016-06-05 00:00:00', '21:15:48', b'0', '2016-06-05 21:15:48', NULL, NULL, NULL),
(30, 1, 0, '2016-06-05 00:00:00', '22:08:19', b'0', '2016-06-05 22:08:19', NULL, NULL, NULL),
(31, 1, 0, '2016-06-06 00:00:00', '10:38:47', b'0', '2016-06-06 10:38:47', NULL, NULL, NULL),
(32, 1, 0, '2016-06-06 00:00:00', '10:40:52', b'0', '2016-06-06 10:40:52', NULL, NULL, NULL),
(33, 1, 0, '2016-06-07 00:00:00', '12:40:02', b'0', '2016-06-07 12:40:02', NULL, NULL, NULL),
(34, 1, 0, '2016-06-07 00:00:00', '15:03:29', b'0', '2016-06-07 15:03:29', NULL, NULL, NULL),
(35, 1, 0, '2016-06-07 00:00:00', '15:04:04', b'0', '2016-06-07 15:04:04', NULL, NULL, NULL),
(36, 1, 0, '2016-06-07 00:00:00', '15:06:36', b'0', '2016-06-07 15:06:36', NULL, NULL, NULL),
(37, 1, 0, '2016-06-08 00:00:00', '07:36:08', b'0', '2016-06-08 07:36:08', NULL, NULL, NULL),
(38, 1, 0, '2016-06-08 00:00:00', '07:48:28', b'0', '2016-06-08 07:48:28', NULL, NULL, NULL),
(39, 1, 0, '2016-06-08 00:00:00', '07:52:05', b'0', '2016-06-08 07:52:05', NULL, NULL, NULL),
(40, 1, 0, '2016-06-08 00:00:00', '07:56:18', b'0', '2016-06-08 07:56:18', NULL, NULL, NULL),
(41, 1, 0, '2016-06-08 00:00:00', '08:00:19', b'0', '2016-06-08 08:00:19', NULL, NULL, NULL),
(42, 1, 0, '2016-06-08 00:00:00', '11:19:53', b'0', '2016-06-08 11:19:53', NULL, NULL, NULL),
(43, 1, 0, '2016-06-15 11:30:11', '13:00:00', b'0', '2016-06-15 11:30:11', NULL, NULL, NULL),
(44, 1, 0, '2016-06-15 11:30:44', '13:00:00', b'0', '2016-06-15 11:30:44', NULL, NULL, NULL),
(45, 1, 0, '2016-06-15 11:32:11', '13:00:00', b'0', '2016-06-15 11:32:11', NULL, NULL, NULL),
(46, 1, 0, '2016-06-15 11:33:25', '13:00:00', b'0', '2016-06-15 11:33:25', NULL, NULL, NULL),
(47, 1, 0, '2016-06-15 11:33:26', '13:00:00', b'0', '2016-06-15 11:33:26', NULL, NULL, NULL),
(48, 1, 0, '2016-06-15 11:33:27', '13:00:00', b'0', '2016-06-15 11:33:27', NULL, NULL, NULL),
(49, 1, 0, '2016-06-15 11:33:27', '13:00:00', b'0', '2016-06-15 11:33:27', NULL, NULL, NULL),
(50, 1, 0, '2016-06-15 11:33:27', '13:00:00', b'0', '2016-06-15 11:33:27', NULL, NULL, NULL),
(51, 1, 0, '2016-06-15 11:33:27', '13:00:00', b'0', '2016-06-15 11:33:27', NULL, NULL, NULL),
(52, 1, 0, '2016-06-15 11:33:27', '13:00:00', b'0', '2016-06-15 11:33:27', NULL, NULL, NULL),
(53, 1, 0, '2016-06-15 11:33:46', '13:00:00', b'0', '2016-06-15 11:33:46', NULL, NULL, NULL),
(54, 1, 0, '2016-06-15 11:35:16', '11:35:16', b'0', '2016-06-15 11:35:16', NULL, NULL, NULL),
(55, 1, 0, '2016-06-15 11:50:06', '11:50:06', b'0', '2016-06-15 11:50:06', NULL, NULL, NULL),
(56, 1, 0, '2016-06-15 11:51:08', '11:51:08', b'0', '2016-06-15 11:51:08', NULL, NULL, NULL),
(57, 1, 0, '2016-06-15 12:16:14', '12:16:14', b'0', '2016-06-15 12:16:14', NULL, NULL, NULL),
(58, 1, 0, '2016-06-15 12:19:07', '12:19:07', b'0', '2016-06-15 12:19:07', NULL, NULL, NULL),
(65, 1, 0, '2016-06-15 14:20:09', '14:20:09', b'0', '2016-06-15 14:20:09', NULL, NULL, NULL),
(60, 1, 0, '2016-06-15 13:02:04', '13:02:04', b'0', '2016-06-15 13:02:04', NULL, NULL, NULL),
(61, 1, 0, '2016-06-15 13:03:12', '13:03:12', b'0', '2016-06-15 13:03:12', NULL, NULL, NULL),
(62, 1, 0, '2016-06-15 13:42:55', '13:42:55', b'0', '2016-06-15 13:42:55', NULL, NULL, NULL),
(63, 1, 0, '2016-06-15 13:43:22', '13:43:22', b'0', '2016-06-15 13:43:22', NULL, NULL, NULL),
(64, 1, 0, '2016-06-15 13:43:42', '13:43:42', b'0', '2016-06-15 13:43:42', NULL, NULL, NULL),
(66, 1, 0, '2016-06-15 17:31:51', '17:31:51', b'1', '2016-06-15 17:31:51', NULL, NULL, NULL),
(67, 1, 0, '2016-06-15 17:45:14', '17:45:14', b'0', '2016-06-15 17:45:14', NULL, NULL, NULL),
(68, 1, 0, '2016-06-15 17:45:48', '17:45:48', b'0', '2016-06-15 17:45:48', NULL, NULL, NULL),
(69, 1, 0, '2016-06-15 21:48:24', '21:48:24', b'0', '2016-06-15 21:48:24', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
 ADD PRIMARY KEY (`idCategoria`), ADD KEY `FK_categoria_idOrganizacao` (`idOrganizacao`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
 ADD PRIMARY KEY (`idCliente`), ADD KEY `FK_cliente_idOrganizacao` (`idOrganizacao`);

--
-- Indexes for table `conta`
--
ALTER TABLE `conta`
 ADD PRIMARY KEY (`idConta`), ADD KEY `FK_conta_idCliente` (`idCliente`);

--
-- Indexes for table `controle_menu`
--
ALTER TABLE `controle_menu`
 ADD PRIMARY KEY (`idControlemenu`), ADD KEY `FK_controle_menu_idOrganizacao` (`idOrganizacao`), ADD KEY `FK_controle_menu_idUsuario` (`idUsuario`), ADD KEY `FK_controle_menu_idMenu` (`idMenu`);

--
-- Indexes for table `controle_submenu`
--
ALTER TABLE `controle_submenu`
 ADD PRIMARY KEY (`idControleSubMenu`), ADD KEY `FK_controle_submenu_idOrganizacao` (`idOrganizacao`), ADD KEY `FK_controle_submenu_idUsuario` (`idUsuario`), ADD KEY `FK_controle_submenu_idSubMenu` (`idSubMenu`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
 ADD PRIMARY KEY (`idDepartamento`), ADD KEY `FK_departamento_idOrganizacao` (`idOrganizacao`);

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
 ADD PRIMARY KEY (`idFornecedor`), ADD KEY `FK_fornecedor_idOrganizacao` (`idOrganizacao`);

--
-- Indexes for table `item_venda`
--
ALTER TABLE `item_venda`
 ADD PRIMARY KEY (`idItem`), ADD KEY `FK_item_venda_idVenda` (`idVenda`), ADD KEY `FK_item_venda_idProduto` (`idProduto`);

--
-- Indexes for table `logacessosusuarios`
--
ALTER TABLE `logacessosusuarios`
 ADD PRIMARY KEY (`LogAcessoUsuarioId`), ADD KEY `FK_LogAcessosUsuarios_idUsuario` (`UsuarioId`);

--
-- Indexes for table `loteprodutos`
--
ALTER TABLE `loteprodutos`
 ADD PRIMARY KEY (`idLote`), ADD KEY `FK_loteprodutos_idOrganizacao` (`idOrganizacao`), ADD KEY `FK_loteprodutos_idFornecedor` (`idFornecedor`), ADD KEY `FK_loteprodutos_idProduto` (`idProduto`);

--
-- Indexes for table `loteprodutosbaixa`
--
ALTER TABLE `loteprodutosbaixa`
 ADD PRIMARY KEY (`LoteProdutoBaixaId`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`idMenu`);

--
-- Indexes for table `organizacao`
--
ALTER TABLE `organizacao`
 ADD PRIMARY KEY (`idOrganizacao`);

--
-- Indexes for table `pagamento`
--
ALTER TABLE `pagamento`
 ADD PRIMARY KEY (`idPagamento`), ADD KEY `FK_pagamento_idOrganizacao` (`idOrganizacao`), ADD KEY `FK_pagamento_idCliente` (`idCliente`);

--
-- Indexes for table `perdas`
--
ALTER TABLE `perdas`
 ADD PRIMARY KEY (`idPerda`), ADD KEY `FK_perdas_idOrganizacao` (`idOrganizacao`), ADD KEY `FK_perdas_idLote` (`idLote`);

--
-- Indexes for table `permissoes`
--
ALTER TABLE `permissoes`
 ADD PRIMARY KEY (`idPermissao`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
 ADD PRIMARY KEY (`idProduto`), ADD KEY `FK_produto_idOrganizacao` (`idOrganizacao`), ADD KEY `FK_produto_idCategoria` (`idCategoria`);

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
 ADD PRIMARY KEY (`idSubMenu`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`idUsuario`), ADD UNIQUE KEY `Token` (`token`), ADD KEY `FK_usuario_idOrganizacao` (`idOrganizacao`), ADD KEY `FK_usuario_idDepartamento` (`idDepartamento`);

--
-- Indexes for table `venda`
--
ALTER TABLE `venda`
 ADD PRIMARY KEY (`idVenda`), ADD KEY `FK_venda_idOrganizacao` (`idOrganizacao`), ADD KEY `FK_venda_idCliente` (`idCliente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `conta`
--
ALTER TABLE `conta`
MODIFY `idConta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `controle_menu`
--
ALTER TABLE `controle_menu`
MODIFY `idControlemenu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=237;
--
-- AUTO_INCREMENT for table `controle_submenu`
--
ALTER TABLE `controle_submenu`
MODIFY `idControleSubMenu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=437;
--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
MODIFY `idFornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `item_venda`
--
ALTER TABLE `item_venda`
MODIFY `idItem` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `logacessosusuarios`
--
ALTER TABLE `logacessosusuarios`
MODIFY `LogAcessoUsuarioId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `loteprodutos`
--
ALTER TABLE `loteprodutos`
MODIFY `idLote` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `loteprodutosbaixa`
--
ALTER TABLE `loteprodutosbaixa`
MODIFY `LoteProdutoBaixaId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `organizacao`
--
ALTER TABLE `organizacao`
MODIFY `idOrganizacao` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=225;
--
-- AUTO_INCREMENT for table `pagamento`
--
ALTER TABLE `pagamento`
MODIFY `idPagamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `perdas`
--
ALTER TABLE `perdas`
MODIFY `idPerda` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissoes`
--
ALTER TABLE `permissoes`
MODIFY `idPermissao` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
MODIFY `idSubMenu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=256;
--
-- AUTO_INCREMENT for table `venda`
--
ALTER TABLE `venda`
MODIFY `idVenda` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
