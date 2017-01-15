<?php

include './sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'Login':
        Login();
        break;
    }
}

function Login() {
    session_start();
    $conexao = AbreBancoJP();
    $sql = "call USP_SEL_LOGIN('".$_POST['login']."', '".md5($_POST['senha'])."');";
    $result = mysql_query($sql, $conexao);    
    $retorno = '1';

    while($row = mysql_fetch_row($result)){
        if($row['0'] > 0){
            $_SESSION['codUsuario'] = $row['0'];
            $_SESSION['nomeUsuario'] = $row['1'];
            $_SESSION['permissao'] = $row['4'];
            $_SESSION['idOrganizacao'] = $row['2'];
            $_SESSION['nomeOrganizacao'] = $row['3'];
        }else{
            $retorno = '0';
        }
    }
    echo $retorno;
}
