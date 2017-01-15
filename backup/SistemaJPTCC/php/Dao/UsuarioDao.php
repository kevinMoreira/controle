<?php
/**
 * @author Kevin Rangel Moreira
 * @since 27/03/2016
 * classe criada para conexão com banco de dados usuário
 */


include '../sistemaJP.php';
require_once('../Ent/Usuario.php');

//require_once("../config.php");
require_once("../Mail.php");
//require_once("../MySQL.php");

class UsuarioDao
{


    public function Obter($pesq)
    {

        session_start();
        $conexao = AbreBancoJP();


        $objUsuarioEnt = new Usuario();

        $sql = "SELECT 
					nome
            ,	idUsuario
			,	idOrganizacao
            ,	idDepartamento
			,	nome
			,	bairro
			,	uf
    		,	cpf
			,	data_nascimento
			,	telefone
			,	celular
			,	email
			,	cep
			,	numero
			,	complemento
			,	status
			,   login
			,   senha
			,   endereco
			 ,   cidade
			 ,   estado	
		   ,	CadastroDataHora
		   ,	CadastroUsuarioId
		   ,	AtualizacaoDataHora
		  ,	AtualizacaoUsuarioId
		  
		FROM 
			usuarios
             
		WHERE
			
            
				(nome = '".$pesq." ' 
                OR
                telefone = '".$pesq. "') 
			
		AND 
			status=1
		AND
			u.idOrganizacao = $_SESSION[idOrganizacao]";

        $sql = mysql_query($sql, $conexao);

        if (mysql_num_rows($sql) <= 0) {
            mysql_close($conexao);
            return 0;
        }

//        while ($row = mysql_fetch_row($sql)) {
        while ($row = mysql_fetch_array($sql)) {

            $objUsuarioEnt->setNome($row['nome']);
            $objUsuarioEnt->setIdUsuario($row['idUsuario']);
            $objUsuarioEnt->setIdOrganizacao($row['idOrganizacao']);
            $objUsuarioEnt->setIdDepartamento($row['idDepartamento']);
            $objUsuarioEnt->setNome($row['nome']);
            $objUsuarioEnt->setCpf($row['cpf']);
           $objUsuarioEnt->setDataNasc($row['data_nascimento']);
            $objUsuarioEnt->setTelefone($row['telefone']);
            $objUsuarioEnt->setCelular($row['celular']);
            $objUsuarioEnt->setEmail($row['email']);
            $objUsuarioEnt->setCep($row['cep']);
            $objUsuarioEnt->setBairo($row['bairro']);
            $objUsuarioEnt->setNumero($row['numero']);
            $objUsuarioEnt->setComplemento($row['complemento']);
            $objUsuarioEnt->setStatus($row['status']);
            $objUsuarioEnt->setLogin($row['login']);
            $objUsuarioEnt->setSenha($row['senha']);

            $objUsuarioEnt->setEndereco($row['endereco']);
            $objUsuarioEnt->setCidade($row['cidade']);
            $objUsuarioEnt->setUf($row['uf']);
            $objUsuarioEnt->setDepartamento($row['idDepartamento']);

        }
        mysql_close($conexao);
        return $objUsuarioEnt;
    }


    public function CarregarComboBox()
    {

        session_start();
        $conexao = AbreBancoJP();

        $sql = "SELECT 
						idDepartamento ,
						nome
				FROM 
					departamento 
				WHERE 
					status=1
				AND
					idOrganizacao =" . $_SESSION['idOrganizacao'];

        $sql = mysql_query($sql, $conexao);

        if (mysql_num_rows($sql) <= 0) {
            mysql_close($conexao);
            return 0;
        }

        while ($row = mysql_fetch_row($sql)) {
            $json[] = array(
                'idDepartamento' => $row[0],
                'nome' => $row[1]
            );
        }
        mysql_close($conexao);
        return $json;
    }


    public function Salvar(Usuario $objUsuario)
    {
        session_start();
        $conexao=AbreBancoJP();
       // echo "<script>alert($_SESSION[idOrganizacao]);</script>";
        $sql="INSERT INTO `usuarios`
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
            `senha`,
            `endereco`,
            `bairro`,
            `cidade`,
            `estado`
       
		)
        VALUES
		(
			 $_SESSION[idOrganizacao],
		
            '".$objUsuario->getIdDepartamento()."',
			'".$objUsuario->getNome()."',
			'".$objUsuario->getCpf()."',
			'".$objUsuario->getDataNasc()."',
			'".$objUsuario->getTelefone()."',
			'".$objUsuario->getCelular()."',
			'".$objUsuario->getEmail()."',
			'".$objUsuario->getCep()."',
            '".$objUsuario->getComplemento()."',
            '".$objUsuario->getNumero()."',
			1,
			current_timestamp(),
			'".$objUsuario->getIdUsuario()."',
			NULL,
			NULL,
            '".$objUsuario->getLogin()."',
            '".md5($objUsuario->getSenha())."',
            '".$objUsuario->getEndereco()."',
            '".$objUsuario->getBairo()."',
            '".$objUsuario->getCidade()."',
            '".$objUsuario->getEstado()."'
      
            
        );
";

        mysql_query($sql, $conexao);

        $retorno = $sql;
        mysql_close($conexao);
        return $retorno;
    }

    public function Atualizar($nome,
          $cpf,
          $data_nascimento,
          $telefone,
          $celular,
          $email,
          $cep,
          $endereco,
          $numero,
          $complemento,
          $bairro,
          $cidade,
          $uf,
          $login,
          $senha,
          $status
          )
    {
        session_start();
        $conexao = AbreBancoJP();

        $sql = " UPDATE
			`usuarios`
		SET

			`nome` = '".$nome."',
			`cpf` = '".$cpf."',
			`data_nascimento` = '".$data_nascimento."',
			`telefone` = '".$telefone."',
			`celular` = '".$celular."',
			`email` = '".$email."',
			`cep` = '".$cep."',
            `complemento` = '".$complemento."',
            `numero` = '".$numero."',
			`status`=1,
			`AtualizacaoDataHora` = current_timestamp(),
		--	`AtualizacaoUsuarioId` = 1
          --  `login` = '".$login."',
         --   `senha` = '".$senha."',
            `endereco` = '".$endereco."',
            `bairro` =  '".$bairro."',
            `cidade` = '".$cidade."',
            `estado` = '".$uf."'
		
		WHERE
			`login` = ".$login."
		AND
			`idOrganizacao`= ".$_SESSION['idOrganizacao'];


//        $sql="UPDATE
//			usuarios
//		SET
//			`telefone` = '".$objUsuario->getTelefone()."'
//			--`celular` = '".$objUsuario->getCelular()."'
//            -- `idDepartamento` = ".$objUsuario->getIdDepartamento().",
//			-- `email` = '".$objUsuario->getEmail()."',
//			-- `cep` =  '".$objUsuario->getCep()."',
//           -- `numero` =  '".$objUsuario->getNumero()."',
//          --  `complemento` = '".$objUsuario->getComplemento()."',
//		-- `AtualizacaoDataHora` = current_timestamp(),
//			-- `AtualizacaoUsuarioId` = ".$objUsuario->getIdUsuario().",
//			-- parte adicionada
//			/*
//			`login` = '".$objUsuario->getLogin()."',
//            `senha` = '".$objUsuario->getSenha()."',
//            `endereco` = '".$objUsuario->getEndereco()."',
//            `bairro` =  '".$objUsuario->getBairo()."',
//            `cidade` = '".$objUsuario->getCidade()."',
//            `estado` = '".$objUsuario->getEstado()."',
//            `nome` = '".$objUsuario->getNome()."',
//			`cpf` = '".$objUsuario->getCpf()."',
//			`data_nascimento` = '".$objUsuario->getDataNasc()."'
//		*/
//		WHERE
//			`idUsuario` = ".$objUsuario->getIdUsuario()."
//
//		 AND
//			`idOrganizacao`= $_SESSION[idOrganizacao]";


        mysql_query($sql, $conexao);
        $retorno = "1";
        mysql_close($conexao);
        return $retorno;
    }


    public function Excluir($id)
    {
        session_start();
        $conexao = AbreBancoJP();

        $sql = "UPDATE
			`usuarios`
		SET
			`status` = 0,
			`AtualizacaoDataHora` = current_timestamp(),
            `AtualizacaoUsuarioId` =".$id." 
		WHERE
			`idUsuario` = ".$id."
		AND
			`idOrganizacao`= ".$_SESSION['idOrganizacao'];

        mysql_query($sql, $conexao);
        $retorno = "1";
        mysql_close($conexao);

        return $retorno;
    }



//    function menu(){
//
//        $conexao = AbreBancoJP();
//
//        $sql = "SELECT m.idMenu AS codgrupo, m.nome AS grupo, s.idSubmenu AS codsubgrupo, IFNULL(s.nome, '') AS subgrupo FROM menu AS m
//            LEFT JOIN sub_menu AS s ON s.idMenu = m.idMenu group by m.nome";
//
//        $Tb = mysql_query($sql, $conexao);
//
//        if(mysql_num_rows($Tb) <= 0){
//            echo '0';
//            mysql_close($conexao);
//            return;
//        }
//
//        while($linha = mysql_fetch_assoc($Tb)){
//
//            $json[] = array(
//                'id_menu' => $linha['codgrupo'],
//                'nome_menu' => $linha['grupo'],
//                'id_submenu' => $linha['codsubgrupo']
//            );
//        }
//
//        echo json_encode($json);
//        mysql_close($conexao);
//
//    }

//    function subMenu(){
//        $conexao = AbreBancoJP();
//
//        $query = "SELECT s.nome, s.idSubmenu FROM sub_menu s where s.idMenu=" . $_POST['id_menu'];
//
//        $query = mysql_query($query, $conexao);
//
//        while($row=mysql_fetch_row($query)){
//
//            $json[] = array(
//                'id_submenu' => $row['1'],
//                'nome_submenu' => $row['0'],
//                //'id_menu' => $_POST['id_menu']//teste
//            );
//        }
//        echo json_encode($json);
//        mysql_close($conexao);
//    }


//    public function Excluir($id)
//    {
//        session_start();
//        $conexao=AbreBancoJP();
//
//
//        $sql="	UPDATE
//			`usuarios`
//		SET
//			`status` = 0,
//			`AtualizacaoDataHora` = current_timestamp()
//
//		WHERE
//
//			  `idUsuario` = ".$id.";";
//
//        mysql_query($sql, $conexao);
//
//
//        $retorno = "1";
//        mysql_close($conexao);
//        return $retorno;
//    }



    function salvarMenu($idOrg, $menu, $submenu){


        $conexao = AbreBancoJP();

        $sql="SELECT idUsuario FROM usuarios where status=1 and idOrganizacao=". $idOrg ." ORDER BY idUsuario DESC LIMIT 1";
        $sql=mysql_query($sql,$conexao);
        $lastIdUsr=mysql_fetch_row($sql);
//        $menu=$_POST['menu'];
//        $submenu=$_POST['subMenu'];
        $menu = explode(',', $menu);
        $submenu = explode(',', $submenu);

        for($i=0; $i < sizeof($menu); $i++){

            $sql="insert into controle_menu values ('',$lastIdUsr[0],$menu[$i], $idOrg)";
            mysql_query($sql,$conexao);

        }

        for($i=0; $i < sizeof($submenu); $i++){

            $sql="insert into controle_submenu values ('',$lastIdUsr[0],$submenu[$i], $_SESSION[idOrganizacao])";
            mysql_query($sql,$conexao);

        }
        $retorno= $sql;
        return $retorno;

        mysql_close($conexao);
    }

//    function pesquisarUsuario(){
//
//        session_start();
//        $conexao= AbreBancoJP();
//
//        $sql="SELECT
//    u.idUsuario,
//    u.idOrganizacao,
//    u.idDepartamento,
//     u.nome,
//     u.cpf,
//     u.data_nascimento,
//    u.telefone,
//    u.celular,
//    u.cep,
//     u.endereco,
//     u.numero,
//     u.complemento,
//     u.bairro,
//     u.cidade,
//      u.estado,
//       u.email,
//        u.login,
//        u.senha,
//        u.permissao,
//         u.status,
//          u.idDepartamento,
//          d.nome
//    from usuarios u,
//    departamento d
//    INNER JOIN departamento d on d.idDepartamento = u.idDepartamento
//    where (u.nome='$_POST[pesq]'
//      OR u.telefone='$_POST[pesq]'
//      OR u.cpf='$_POST[pesq]')
//    and u.status=1 and u.idOrganizacao=". $_SESSION['idOrganizacao'] ."
//    and d.status=1 and d.idOrganizacao=" .$_SESSION['idOrganizacao'];
//
//        $sql=mysql_query($sql, $conexao);
//
//        if(mysql_num_rows($sql) <= 0){
//            echo '0';
//            mysql_close($conexao);
//            return;
//        }
//
//        while($row=mysql_fetch_row($sql)){
//
//            $json[]= array(
//                'id_usuario' => $row['0'],
//                'nome' => $row['3'],
//                'cpf' => $row['4'],
//                'data_nascimento' => $row['5'],
//                'telefone' => $row['6'],
//                'celular' => $row['7'],
//                'cep' => $row['8'],
//                'endereco' => $row['9'],
//                'numero' => $row['10'],
//                'complemento' => $row['11'],
//                'bairro' => $row['12'],
//                'cidade' => $row['13'],
//                'uf' => $row['14'],
//                'email' => $row['15'],
//                'login' => $row['16'],
//                'senha' => $row['17'],
//                'permissao' => $row['18'],
//                'status' => $row['19'],
//                'idDepartamento' => $row['20'],
//                'nomeDepartamento' => $row['21']
//            );
//        }
//
//        echo json_encode($json);
//        mysql_close($conexao);
//    }

//    function pesquisarMenuUsuario(){
//
//        $conexao= AbreBancoJP();
//
//        $sql="SELECT cm.idMenu, m.nome from controle_menu cm
//    INNER JOIN menu m on m.idMenu = cm.idMenu
//    /*LEFT JOIN sub_menu s ON s.id_menu = m.id_menu group by m.nome*/
//    where cm.idUsuario = $_POST[id_usuario]";
//
//        $sql=mysql_query($sql,$conexao);
//
//        while ($row=mysql_fetch_row($sql)){
//
//            $json[] = array(
//                'id_menu' => $row[0],
//                'nome' => $row[1],
//                //'id_submenu' => $row[2]
//            );
//        }
//
//        echo json_encode($json);
//        mysql_close($conexao);
//    }

//    function pesquisarSubMenuUsuario(){
//
//        $conexao= AbreBancoJP();
//
//        $sql="SELECT idSubmenu from controle_submenu where idUsuario = $_POST[id_usuario]";
//
//        $sql=mysql_query($sql,$conexao);
//
//        while ($row=mysql_fetch_row($sql)){
//
//            $json[] = array(
//                'id_submenu' => $row[0]
//            );
//        }
//
//        echo json_encode($json);
//        mysql_close($conexao);
//    }
//
//
//
//    function editarMenu()
//    {
//
//        session_start();
//        $conexao = AbreBancoJP();
//        $menu = $_POST['menu'];
//        $submenu = $_POST['subMenu'];
//        $menu = explode(',', $menu);
//        $submenu = explode(',', $submenu);
//        $sql = "DELETE FROM controle_menu WHERE idUsuario = $_POST[id_usuario] and idOrganizacao=" . $_SESSION['idOrganizacao'];
//        mysql_query($sql, $conexao);
//
//        $sql = "DELETE FROM controle_submenu WHERE idUsuario = $_POST[id_usuario] and idOrganizacao=" . $_SESSION['idOrganizacao'];
//        mysql_query($sql, $conexao);
//
//        for ($i = 0; $i < sizeof($menu); $i++) {
//
//            $sql = "INSERT into controle_menu values ('', $_POST[id_usuario], $menu[$i], $_SESSION[idOrganizacao])";
//            mysql_query($sql, $conexao);
//
//        }
//
//        for ($i = 0; $i < sizeof($submenu); $i++) {
//
//            $sql = "INSERT into controle_submenu values ('', $_POST[id_usuario],$submenu[$i], $_SESSION[idOrganizacao])";
//            mysql_query($sql, $conexao);
//
//        }
//        mysql_close($conexao);
//    }


    public function Login($login,$senha)
    {
        session_start();
        $conexao = AbreBancoJP();


    $sql = "call USP_SEL_LOGIN('".$login ."', '". md5($senha)."');";

        $result = mysql_query($sql, $conexao);

        while ($row = mysql_fetch_row($result)) {
            if($row['0']>0){
                $_SESSION['codUsuario'] = $row['0'];
                $_SESSION['nomeUsuario'] = $row['1'];
                $_SESSION['permissao'] = $row['4'];
                $_SESSION['idOrganizacao'] = $row['2'];
                $_SESSION['nomeOrganizacao'] = $row['3'];
            }else{
                return 0 ;
            }
        }


        if (mysql_num_rows($result) <= 0) {
            return '0';
        } else {
            return '1';
        }
        mysql_close($conexao);
    }
    //Cadastrando menus

//    public function SalvarMenu($menu,$submenu){
//        session_start();
//        $conexao = AbreBancoJP();
//
//        $sql="SELECT idUsuario FROM usuarios where status=1 and idOrganizacao=". $_SESSION['idOrganizacao'] ." ORDER BY idUsuario DESC LIMIT 1";
//        $sql=mysql_query($sql,$conexao);
//        $lastIdUsr=mysql_fetch_row($sql);
//
//
//        $menu = explode(',', $menu);
//        $submenu = explode(',', $submenu);
//
//        for($i=0; $i < sizeof($menu); $i++){
//
//            $sql="insert into controle_menu values ('',$lastIdUsr[0],$menu[$i], $_SESSION[idOrganizacao])";
//            mysql_query($sql,$conexao);
//
//        }
//
//        for($i=0; $i < sizeof($submenu); $i++){
//
//            $sql="insert into controle_submenu values ('',$lastIdUsr[0],$submenu[$i], $_SESSION[idOrganizacao])";
//            mysql_query($sql,$conexao);
//
//        }
//
//        mysql_close($conexao);
//
//    }



//gravando o usuarios


    public  function Gravar(Usuario $objUsuario, $estabelecimento)
    {
        session_start();
//        $conexao = new MySQL();
        $conexao = AbreBancoJP();
        $sql = " INSERT INTO organizacao
		(
			nome,
			STATUS,
			CadastroDataHora
		)
		VALUES
		(
		    '" . $estabelecimento . "',
			1,
			CURRENT_TIMESTAMP()
		);";
        mysql_query($sql, $conexao);


        $sql = "INSERT INTO usuarios
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
			 (select (idOrganizacao) from organizacao order by CadastroDataHora desc LIMIT 1 ),
		   /*  213,*/
			NULL,
			'" . $objUsuario->getNome() . "',
			NULL,
			'" . $objUsuario->getTelefone() . "',
			'" . $objUsuario->getEmail() . "',
			'" . md5($objUsuario->getEmail()) . "',
			'" . md5($objUsuario->getSenha()) . "',
			2,
			1,
			CURRENT_TIMESTAMP(),
			(SELECT md5(FLOOR(RAND() * 1000000))),-- TOKEN
			(select DATE_ADD(current_timestamp(), INTERVAL 7 DAY))-- DATA VALIDADE TOKEN DATA HOJE + 7 DIAS
		);";

        $retorno=mysql_query($sql, $conexao);
//        mysql_query($sql, $conexao);

//        $retorno = $conexao->execSP($sql);


        if ($retorno[0] != '0') {
            $email = new Mail();
            $email->nomeremetente = "SISJP";
            $email->emailremetente = "contato@jpe.bl.ee";
            $email->emaildestinatario = "$_POST[txtEmail]";
            $email->comcopia = "joaopaulo_391@hotmail.com";
            $email->comcopiaoculta = "joaopaulo_391@hotmail.com";
            $email->assunto = "Bem Vindo $_POST[txtNome]";
            $email->mensagem = "";
            $email->emailsender = "contato@jpe.bl.ee";
            $email->mensagemHTML = "<html>
                     <head>
                         <meta charset='utf-8'>
                     </head>
                     <body>

                         <p>Bem Vindo!</p>
                         <p>Seguem abaixo seus dados cadastrais.</p>
                         <table>
                             <tr>
                                 <td>
                                     Login: <strong>$_POST[txtEmail]</strong>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     Senha: <strong>$_POST[txtSenha]</strong>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     Email: <strong>$_POST[txtEmail]</strong>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     Empreendimento: <strong>$_POST[txtEstabelecimento]</strong>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     Telefone: <strong>$_POST[txtTelefone]</strong>
                                 </td>
                             </tr>
                              <tr>
                                 <td>
                                     Para validar o seu cadastro <a href='http://www.jpe.bl.ee/php/valida-token.php/?token=" . $retorno['Token'] . "'><strong>clique aqui.</strong></a> Prazo de validade de 7 dias após o cadastro.
                                 </td>
                             </tr>
                         </table>
                     </body>
                     </html>";

            echo $email->mensagemHTML;
             $email->Envia();
            echo 1;
        }else{
            echo 0;
        }


//            $retorno = "1";
            mysql_close($conexao);
            return $retorno;
        }
    }
