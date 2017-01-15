
$(document).ready(function(){
    $JQuery("#txtEmail").focus();
    $JQuery(".campos_cadastre_se").click(function(){
        $JQuery(".error").hide();
    });
});

function EnviarSenha() {
    if ($JQuery("#txtEmail").val() == "") {
        $JQuery("#spnEmail").parent().parent().show();
        $JQuery("#txtEmail").focus();
        return;
    }

    var ajax = new Ajax('POST', 'php/esqueci-minha-senha.php', false);

    var txtEmail = document.getElementById('txtEmail').value;

    var p = 'action=Enviar';
    p += '&txtEmail=' + txtEmail;

    ajax.Request(p);

    //var json = JSON.parse(ajax.getResponseText());

    if (ajax.getResponseText() == '0') {
        alert("Há mais de uma conta registrada com o mesmo login. Favor entrar em contato com a central de atendimento através do email contato@jpe.bl.ee.");
        $JQuery('input[type=text]').val('');
        return;
    } else {
        $JQuery(".conteudo_cadastre_se").hide();
        $JQuery(".menu_cadastro").hide();
        $JQuery(".divSucesso").show();
    }
}