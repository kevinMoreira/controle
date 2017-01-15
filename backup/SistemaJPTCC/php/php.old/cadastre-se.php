<?php
include 'sistemaJP.php';
require_once("config.php");
require_once("Mail.php");
require_once("MySQL.php");


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'Gravar':
            Gravar();
            break;
    }
}


//---------------------------------------------------------------------------------------------------------
// 05/06/2015
//---------------------------------------------------------------------------------------------------------
//Cria usuário no sistema
function Gravar(){

    $conexao = new MySQL();

    $sql="set @ORGANIZACAO_ = '$_POST[txtEstabelecimento]';
            set @NOME = '$_POST[txtNome]';
            set @TELEFONE = '$_POST[txtTelefone]';
            set @EMAIL = '$_POST[txtEmail]';
            set @SENHA = '$_POST[txtSenha]';
            call USP_INS_CADASTRO_USUARIO(@ORGANIZACAO_, @NOME, @TELEFONE, @EMAIL, @SENHA);";

    $retorno = $conexao->execSP($sql);

    if($retorno[0]!= '0'){
        $email= new Mail();
        $email->nomeremetente     = "SISJP";
        $email->emailremetente    = "contato@jpe.bl.ee";
        $email->emaildestinatario = "$_POST[txtEmail]";
        $email->comcopia          = "joaopaulo_391@hotmail.com";
        $email->comcopiaoculta    = "joaopaulo_391@hotmail.com";
        $email->assunto           = "Bem Vindo $_POST[txtNome]";
        $email->mensagem          = "";
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
                                     Para validar o seu cadastro <a href='http://www.jpe.bl.ee/php/valida-token.php/?token=".$retorno['Token']."'><strong>clique aqui.</strong></a> Prazo de validade de 7 dias após o cadastro.
                                 </td>
                             </tr>
                         </table>
                     </body>
                     </html>";

        echo $email->mensagemHTML;
       // $email->Envia();
        echo 1;
    }else{
        echo 0;
    }
}
