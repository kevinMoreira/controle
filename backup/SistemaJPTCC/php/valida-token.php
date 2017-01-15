<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 14/06/2015
 * Time: 21:21
 */
require_once("MySQL.php");

if (isset($_REQUEST['token'])) {
    validaToken();
}

function validaToken(){

    $conexao = new MySQL();

    $sql="set @TOKEN = '$_REQUEST[token]';
            call USP_SEL_VALIDA_TOKEN(@TOKEN);";

    $retorno = $conexao->execSP($sql);

    session_start();
    $_SESSION['codUsuario'] = $retorno["codUsuario"];
    $_SESSION['nomeUsuario'] = $retorno["nome"];
    $_SESSION['permissao'] = $retorno["permissao"];
    $_SESSION['idOrganizacao'] = $retorno["idOrganizacao"];
    $_SESSION['nomeOrganizacao'] = $retorno["nomeOrganizacao"];

    header("Location:../principal.html");
}