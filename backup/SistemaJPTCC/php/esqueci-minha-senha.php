<?php
include 'sistemaJP.php';
require_once("config.php");
require_once("Mail.php");
require_once("MySQL.php");


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'Enviar':
            Enviar();
            break;
    }
}


//---------------------------------------------------------------------------------------------------------
// 05/06/2015
//---------------------------------------------------------------------------------------------------------
//Envia nova senha para usuário
function Enviar(){

    $conexao = new MySQL();

    $sql="set @EMAIL_ = '$_POST[txtEmail]';

            call USP_UPD_ESQUECI_MINHA_SENHA(@EMAIL_);";

    $retorno = $conexao->execSP($sql);

    if($retorno[0] != '0'){
        $email= new Mail();
        $email->nomeremetente     = "SISJP";
        $email->emailremetente    = "contato@jpe.bl.ee";
        $email->emaildestinatario = "$_POST[txtEmail]";
        $email->comcopia          = "joaopaulo_391@hotmail.com";
        $email->comcopiaoculta    = "joaopaulo_391@hotmail.com";
        $email->assunto           = "Esqueci Minha Senha SISJP";
        $email->mensagem          = "";
        $email->emailsender = "contato@jpe.bl.ee";
        $email->mensagemHTML = "<html>
                     <head>
                         <meta charset='utf-8'>
                     </head>
                     <body>

                         <p>Olá, ".$retorno["nome"]."</p>
                         <p>Seguem abaixo seus dados cadastrais.</p>
                         <table>
                             <tr>
                                 <td>
                                     Login: <strong>".$retorno["login"]."</strong>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     Senha: <strong>".$retorno["senha"]."</strong>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     Email: <strong>".$retorno["email"]."</strong>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     Empreendimento: <strong>".$retorno["organizacao"]."</strong>
                                 </td>
                             </tr>
                         </table>
                     </body>
                     </html>";
        $email->Envia();
        echo 1;
    }else{
        echo 0;
    }
}
