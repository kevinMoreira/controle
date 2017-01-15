<?php
include 'sistemaJP.php';
// require_once("config.php");
require_once("Mail.php");
// require_once("MySQL.php");


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

    //$conexao = new MySQL();
    session_start();
    $conexao=AbreBancoJP();

    $sql="call USP_INS_CADASTRO_USUARIO('".$_POST["txtEstabelecimento"]."', '".$_POST["txtNome"]."', '".$_POST["txtTelefone"]."', '".$_POST["txtEmail"]."', '".$_POST["txtSenha"]."');";

    $sql=mysql_query($sql, $conexao);

    while($row=mysql_fetch_row($sql)){
        if($row["0"]>0)
            $retorno = $row["3"];
        else
            return 0;
    }

    if($retorno != null){
        $email= new Mail();
        $email->nomeremetente     = "Processor Controle de estoque";
        $email->emailremetente    = "contato@jafreela.com.br";
        $email->emaildestinatario = "$_POST[txtEmail]";
        $email->comcopia          = "joaopaulo_391@hotmail.com";
        $email->comcopiaoculta    = "joaopaulo_391@hotmail.com";
        $email->assunto           = "Bem Vindo $_POST[txtNome]";
        $email->mensagem          = "";
        $email->emailsender = "contato@jafreela.com.br";
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
                                     Para validar o seu cadastro <a href='http://processor.jafreela.com.br/php/valida-token.php/?token=".$retorno."'><strong>clique aqui.</strong></a> Prazo de validade de 7 dias após o cadastro.
                                 </td>
                             </tr>
                         </table>
                     </body>
                     </html>";

        $email->Envia();
        echo 1;

        mysql_close($conexao);
    }else{
        echo 0;
    }
}
