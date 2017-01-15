<?php

include '../config.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'VerificaSessao':
            VerificaSessao();
            break;

        case 'DestroiSessao':
            DestroiSessao();
            break;

        case 'MontaMenu':
            MontaMenu();
            break;

        case 'getDadosUsuario':
            getDadosUsuario();
            break;
    }
}

function AbreBanco($host, $user, $pass, $database = '') {

    $id = mysql_connect($host, $user, $pass);

    if ($database != '')
        mysql_select_db($database, $id);

    return $id;
}

function AbreBancoJP() {

    $con = new config();

    $id = AbreBanco($con->get_host(), $con->get_login(), $con->get_pass(), $con->get_banco());

    mysql_set_charset('utf8', $id);

    return $id;
}

function VerificaSessao() {

    session_start();

    if (isset($_SESSION['codUsuario'])) {
        echo '1';
    } else {
        echo '0';
    }
}

function DestroiSessao() {

    session_start();
    session_destroy();
}

function MontaMenu() {

    session_start();
    $conexao = AbreBancoJP();

    if ($_SESSION['permissao'] === '1') {
        $sql = "SELECT idMenu, nome FROM menu";
    }else{
        $sql = "SELECT m.idMenu, m.nome, m.link FROM controle_menu AS c
                INNER JOIN menu AS m ON m.idMenu = c.idMenu
                INNER JOIN usuarios AS u ON u.idUsuario = c.idUsuario
                WHERE c.idOrganizacao=".  $_SESSION['idOrganizacao'] ." and c.idUsuario=" . $_SESSION['codUsuario'];
    }

    $Tb = mysql_query($sql, $conexao);

    $menu = "<div class='menu'>
                <ul>";

    $menu .= "<li class='item_menu'><a onclick=window.location='principal.html'>Home</a></li>";

    while ($linha = mysql_fetch_row($Tb)) {
    
        $menu.= "<li class='item_menu'>
                        <a href=" . $linha['2'] . ">" . $linha['1'] . "</a>
                <ul>";
    
    
        $query="SELECT s.nome, s.link from sub_menu s
              INNER JOIN controle_submenu cs on cs.idSubmenu = s.idSubmenu
              /*INNER JOIN sub_menu s on s.id_submenu = cs.id_submenu
              INNER JOIN usuarios u on u.id_usuario = cs.id_usuario*/
              WHERE s.idMenu=$linha[0] AND cs.idUsuario=$_SESSION[codUsuario] and idOrganizacao=". $_SESSION['idOrganizacao'];

        $query=mysql_query($query,$conexao);
        
        while($row = mysql_fetch_row($query)){

            $menu .= "<li class='item_menu'>
                        <a href=" . $row['1'] . ">" . $row['0'] . "</a>
                        </li>
                    </li>";
        }
        $menu .= "</ul>";
    }

    $menu .= "<li class='item_menu'><a onclick=window.location='index.php'>Sair</a></li>";

    $menu.= "</ul></div>";

    echo $menu;
    mysql_close($conexao);
}

function getDadosUsuario(){

    session_start();

    echo $_SESSION['nomeUsuario'] ." - ". $_SESSION['nomeOrganizacao'];
}