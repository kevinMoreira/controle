<?php

include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'menu':
            menu();
            break;

        case 'subMenu':
            subMenu();
            break;

        case 'salvarUsuario':
            salvarUsuario();
            break;

        case 'salvarMenu':
            salvarMenu();
            break;

        case 'pesquisarUsuario':
            pesquisarUsuario();
            break;

        case 'pesquisarMenuUsuario':
            pesquisarMenuUsuario();
            break;

        case 'pesquisarSubMenuUsuario':
            pesquisarSubMenuUsuario();
            break;

        case 'excluir':
            excluir();
            break;

        case 'editarUsuario':
            editarUsuario();
            break;

        case 'editarMenu':
            editarMenu();
            break;

        case 'carregaDep':
            carregaDep();
            break;
    }
}

function carregaDep(){

    session_start();
    $conexao = AbreBancoJP();

    $sql = "select * from departamento where status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];;
    //echo $sql;
    $sql = mysql_query($sql, $conexao);

    while ($row = mysql_fetch_row($sql)) {
        $json[] = array(
            'idDepartamento' => $row['0'],
            'idOrganizacao' => $row['1'],
            'nome' => $row['2']
        );
    }
    echo json_encode($json);
    mysql_close($conexao);
}

function menu(){

    $conexao = AbreBancoJP();

    $sql = "SELECT m.idMenu AS codgrupo, m.nome AS grupo, s.idSubmenu AS codsubgrupo, IFNULL(s.nome, '') AS subgrupo FROM menu AS m
            LEFT JOIN sub_menu AS s ON s.idMenu = m.idMenu group by m.nome";

    $Tb = mysql_query($sql, $conexao);

    if(mysql_num_rows($Tb) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($linha = mysql_fetch_assoc($Tb)){

        $json[] = array(
            'id_menu' => $linha['codgrupo'],
            'nome_menu' => $linha['grupo'],
            'id_submenu' => $linha['codsubgrupo']
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function subMenu(){
    $conexao = AbreBancoJP();

    $query = "SELECT s.nome, s.idSubmenu FROM sub_menu s where s.idMenu=" . $_POST['id_menu'];

    $query = mysql_query($query, $conexao);

    while($row=mysql_fetch_row($query)){

        $json[] = array(
            'id_submenu' => $row['1'],
            'nome_submenu' => $row['0'],
            //'id_menu' => $_POST['id_menu']//teste
        );
    }
    echo json_encode($json);
    mysql_close($conexao);
}


//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function salvarUsuario(){

    session_start();
    $conexao=AbreBancoJP();

    $sql="INSERT INTO usuarios VALUES 
    ('', '$_SESSION[idOrganizacao]', '$_POST[idDepartamento]', '$_POST[nome]','$_POST[cpf]','$_POST[data_nascimento]','$_POST[telefone]',
        '$_POST[celular]','$_POST[cep]','$_POST[endereco]','$_POST[numero]',
        '$_POST[complemento]','$_POST[bairro]','$_POST[cidade]','$_POST[uf]',
        '$_POST[email]',md5('$_POST[login]'),md5('$_POST[senha]'),2,1)";

    mysql_query($sql, $conexao);
    mysql_close($conexao);
}

function salvarMenu(){

    session_start();
    $conexao = AbreBancoJP();

    $sql="SELECT idUsuario FROM usuarios where status=1 and idOrganizacao=". $_SESSION['idOrganizacao'] ." ORDER BY idUsuario DESC LIMIT 1";
    $sql=mysql_query($sql,$conexao);
    $lastIdUsr=mysql_fetch_row($sql);
    $menu=$_POST['menu'];
    $submenu=$_POST['subMenu'];
    $menu = explode(',', $menu);
    $submenu = explode(',', $submenu);

    for($i=0; $i < sizeof($menu); $i++){

        $sql="insert into controle_menu values ('',$lastIdUsr[0],$menu[$i], $_SESSION[idOrganizacao])";
        mysql_query($sql,$conexao);

    }

    for($i=0; $i < sizeof($submenu); $i++){

        $sql="insert into controle_submenu values ('',$lastIdUsr[0],$submenu[$i], $_SESSION[idOrganizacao])";
        mysql_query($sql,$conexao);

    }

    mysql_close($conexao);
}

function pesquisarUsuario(){

    session_start();
    $conexao= AbreBancoJP();

    $sql="SELECT u.idUsuario, u.idOrganizacao, u.idDepartamento, u.nome, u.cpf, u.data_nascimento, 
    u.telefone, u.celular, u.cep, u.endereco, u.numero, u.complemento, u.bairro, u.cidade, u.estado, u.email, u.login, u.senha, u.permissao, u.status, u.idDepartamento, d.nome
    from usuarios u
    INNER JOIN departamento d on d.idDepartamento = u.idDepartamento
    where (u.nome='$_POST[pesq]' OR u.telefone='$_POST[pesq]' OR u.cpf='$_POST[pesq]') 
    and u.status=1 and u.idOrganizacao=". $_SESSION['idOrganizacao'] ."
    and d.status=1 and d.idOrganizacao=" .$_SESSION['idOrganizacao'];

    $sql=mysql_query($sql, $conexao);

    if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($sql)){

        $json[]= array(
            'id_usuario' => $row['0'],
            'nome' => $row['3'],
            'cpf' => $row['4'],
            'data_nascimento' => $row['5'],
            'telefone' => $row['6'],
            'celular' => $row['7'],
            'cep' => $row['8'],
            'endereco' => $row['9'],
            'numero' => $row['10'],
            'complemento' => $row['11'],
            'bairro' => $row['12'],
            'cidade' => $row['13'],
            'uf' => $row['14'],
            'email' => $row['15'],
            'login' => $row['16'],
            'senha' => $row['17'],
            'permissao' => $row['18'],
            'status' => $row['19'],
            'idDepartamento' => $row['20'],
            'nomeDepartamento' => $row['21']
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function pesquisarMenuUsuario(){

    $conexao= AbreBancoJP();

    $sql="SELECT cm.idMenu, m.nome from controle_menu cm
    INNER JOIN menu m on m.idMenu = cm.idMenu
    /*LEFT JOIN sub_menu s ON s.id_menu = m.id_menu group by m.nome*/
    where cm.idUsuario = $_POST[id_usuario]";

    $sql=mysql_query($sql,$conexao);

    while ($row=mysql_fetch_row($sql)){

        $json[] = array(
            'id_menu' => $row[0],
            'nome' => $row[1],
            //'id_submenu' => $row[2]
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function pesquisarSubMenuUsuario(){

    $conexao= AbreBancoJP();

    $sql="SELECT idSubmenu from controle_submenu where idUsuario = $_POST[id_usuario]";

    $sql=mysql_query($sql,$conexao);

    while ($row=mysql_fetch_row($sql)){

        $json[] = array(
            'id_submenu' => $row[0]
        );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function excluir(){//modificar nao excluir fisicamente. Utilizar campo del

    session_start();
    $conexao = AbreBancoJP();

    $sql = "UPDATE usuarios set status = 0 where idUsuario = $_POST[id_usuario] and idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";
    mysql_query($sql,$conexao);

//---------------------------------------------------------------------------------------------------------
// Menu e Submenu não serão deletados. Se o usuário for reativado as opções de menu e submenu estarão salvas
//---------------------------------------------------------------------------------------------------------

    // $sql="DELETE FROM controle_menu WHERE idUsuario = '$_POST[id_usuario]'";
    // $sql=mysql_query($sql,$conexao);

    // $sql="DELETE FROM controle_submenu WHERE idUsuario = '$_POST[id_usuario]'";
    // $sql=mysql_query($sql,$conexao);

    mysql_close($conexao);
}


//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO NA CLAUSULA WHERE
//---------------------------------------------------------------------------------------------------------
function editarUsuario(){

    session_start();
    $conexao=AbreBancoJP();

    $sql="UPDATE usuarios set nome='$_POST[nome]', cpf='$_POST[cpf]', idDepartamento='$_POST[idDepartamento]',
    data_nascimento='$_POST[data_nascimento]', telefone='$_POST[telefone]',
    celular='$_POST[celular]', cep='$_POST[cep]', endereco='$_POST[endereco]', 
    numero='$_POST[numero]',complemento='$_POST[complemento]', bairro='$_POST[bairro]', 
    cidade='$_POST[cidade]', estado='$_POST[uf]',email='$_POST[email]', login= md5('$_POST[login]'), 
    senha=md5('$_POST[senha]')
    WHERE idUsuario = $_POST[id_usuario] and status=1 and idOrganizacao=". $_SESSION['idOrganizacao'];

    mysql_query($sql, $conexao);
    mysql_close($conexao);
}

function editarMenu(){

    session_start();
    $conexao = AbreBancoJP();
    $menu=$_POST['menu'];
    $submenu=$_POST['subMenu'];
    $menu = explode(',', $menu);
    $submenu = explode(',', $submenu);
    $sql="DELETE FROM controle_menu WHERE idUsuario = $_POST[id_usuario] and idOrganizacao=" .$_SESSION['idOrganizacao'];
    mysql_query($sql,$conexao);

    $sql="DELETE FROM controle_submenu WHERE idUsuario = $_POST[id_usuario] and idOrganizacao=" .$_SESSION['idOrganizacao'];
    mysql_query($sql,$conexao);

    for($i=0; $i < sizeof($menu); $i++){

        $sql="INSERT into controle_menu values ('', $_POST[id_usuario], $menu[$i], $_SESSION[idOrganizacao])";
        mysql_query($sql,$conexao);

    }

    for($i=0; $i < sizeof($submenu); $i++){

        $sql="INSERT into controle_submenu values ('', $_POST[id_usuario],$submenu[$i], $_SESSION[idOrganizacao])";
        mysql_query($sql,$conexao);

    }
    mysql_close($conexao);
}