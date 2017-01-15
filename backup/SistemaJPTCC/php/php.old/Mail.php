<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 06/06/2015
 * Time: 14:33
 */

class Mail
{

    public $emailsender;
    public $nomeremetente;
    public $emailremetente;
    public $emaildestinatario;
    public $comcopia;
    public $comcopiaoculta;
    public $assunto;
    public $mensagem;
    public $mensagemHTML;
    public $quebra_linha;
    public $headers;

    public function Envia()
    {
        if(PHP_OS == "Linux") $this->quebra_linha = "\n"; //Se for Linux
        elseif(PHP_OS == "WINNT") $this->quebra_linha = "\r\n"; // Se for Windows
        else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");

        /* Montando o cabe�alho da mensagem */
        $this->headers = "MIME-Version: 1.1".$this->quebra_linha;
        $this->headers .= "Content-type: text/html; charset=iso-8859-1".$this->quebra_linha;
        $this->headers .= "X-Sender: <".$this->emailsender.">".$this->quebra_linha;
        $this->headers .= "X-Mailer: PHP".$this->quebra_linha;

        // Perceba que a linha acima cont�m "text/html", sem essa linha, a mensagem n�o chegar� formatada.
        $this->headers .= "From: ".$this->nomeremetente."<".$this->emailsender.">".$this->quebra_linha;
        $this->headers .= "Return-Path: test<" . $this->emailsender .">". $this->quebra_linha;
        // Esses dois "if's" abaixo s�o porque o Postfix obriga que se um cabe�alho for especificado, dever� haver um valor.
        // Se n�o houver um valor, o item n�o dever� ser especificado.
        if(strlen($this->comcopia) > 0) $this->headers .= "Cc: ".$this->comcopia.$this->quebra_linha;
        if(strlen($this->comcopiaoculta) > 0) $this->headers .= "Bcc: ".$this->comcopiaoculta.$this->quebra_linha;
        $this->headers .= "Reply-To: ".$this->emailremetente."<".$this->emailremetente.">".$this->quebra_linha;
        // Note que o e-mail do remetente ser� usado no campo Reply-To (Responder Para)

        /* Enviando a mensagem */
        mail($this->emaildestinatario, $this->assunto, $this->mensagemHTML, $this->headers, "-r". $this->emailsender);

        /* Mostrando na tela as informa��es enviadas por e-mail */
        /*print "Mensagem <b>$this->assunto</b> enviada com sucesso!<br><br>
        De: $this->emailsender<br>
        Para: $this->emaildestinatario<br>
        Com c&oacute;pia: $this->comcopia<br>
        Com c&oacute;pia Oculta: $this->comcopiaoculta<br>
        <p><a href='".$_SERVER["HTTP_REFERER"]."'>Voltar</a></p>";*/
    }
}
