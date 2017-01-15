<?php

include './sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'Login':
            Login($_POST['login'],$_POST['senha']);
//            Login('698dc19d489c4e4db73e28a713eab07b','81dc9bdb52d04dc20036dbd8313ed055');
            break;
    }
}

function Login($login,$senha) {
    session_start();
    $conexao = AbreBancoJP();
//    $sql = "call USP_SEL_LOGIN('".$login."', '".md5($senha)."');";
    $sql = "call USP_SEL_LOGIN('".base64_encode($login)."', '".base64_encode($senha)."');";
//    $sql = "call USP_SEL_LOGIN('".$login."', '".$senha."');";
//    $sql="call USP_SEL_LOGIN('698dc19d489c4e4db73e28a713eab07b', '81dc9bdb52d04dc20036dbd8313ed055');";

    $result = mysql_query($sql, $conexao);

    while($row = mysql_fetch_row($result)){


        $_SESSION['codUsuario'] = $row['0'];
        $_SESSION['nomeUsuario'] = $row['1'];
        $_SESSION['permissao'] = $row['4'];
        $_SESSION['idOrganizacao'] = $row['2'];
        $_SESSION['nomeOrganizacao'] = $row['3'];
    }



    if (mysql_num_rows($result) <= 0) {
        echo '0';
        mysql_close($conexao);
        return;
    } else {
        echo '1';
    }


    mysql_close($conexao);
}
