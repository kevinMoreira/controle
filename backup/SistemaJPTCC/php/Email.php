<?php

require_once("Mail.php");

$email= new Mail();

$email->nomeremetente     = 'Jp';
$email->emailremetente    = "contato@jpe.bl.ee";
$email->emaildestinatario = "joaopaulo_391@hotmail.com";
$email->comcopia          = "joaopaulo_391@hotmail.com";
$email->comcopiaoculta    = "joaopaulo_391@hotmail.com";
$email->assunto           = "uhauhauhauhauhauahuahuahua";
$email->mensagem          = "ldfhsdfldslkfjs";
$email->emailsender = "contato@jpe.bl.ee";
/* Montando a mensagem a ser enviada no corpo do e-mail. */
$email->mensagemHTML = '<P>Esse email &eacute; um teste enviado no formato HTML via PHP mail();!</P>
<P>Aqui est&aacute; a mensagem postada por voc&ecirc; formatada em HTML:</P>
<p><b><i>'.$email->mensagem.'</i></b></p>
<hr>';

$email->Envia();

