
$(document).ready(function(){
    $JQuery("#txtEstabelecimento").focus();
    $JQuery(".campos_cadastre_se").click(function(){
        $JQuery(".error").hide();
    });
});

function Cadastrar(){
    if($JQuery("#txtEstabelecimento").val() == ""){
        $JQuery("#spnEstabelecimento").parent().parent().show();
        $JQuery("#txtEstabelecimento").focus();
        return;
    }

    if($JQuery("#txtNome").val() == ""){
        $JQuery("#spnNome").parent().parent().show();
        $JQuery("#txtNome").focus();
        return;
    }

    if($JQuery("#txtTelefone").val() == ""){
        $JQuery("#spnTelefone").parent().parent().show();
        $JQuery("#txtTelefone").focus();
        return;
    }

    if($JQuery("#txtEmail").val() == ""){
        $JQuery("#spnEmail").parent().parent().show();
        $JQuery("#txtEmail").focus();
        return;
    }

    if($JQuery("#txtSenha").val() == ""){
        $JQuery("#spnSenha").parent().parent().show();
        $JQuery("#txtSenha").focus();
        return;
    }

    if($JQuery("#txtCSenha").val() == ""){
        $JQuery("#spnCSenha").parent().parent().show();
        $JQuery("#txtCSenha").focus();
        return;
    }

    if($JQuery("#txtCSenha").val() != $JQuery("#txtSenha").val()){
        $JQuery("#spnCSenha").parent().parent().show();
        $JQuery("#spnSenha").parent().parent().show();
        $JQuery("#txtCSenha").val('');
        $JQuery("#txtSenha").val('');
        $JQuery("#txtSenha").focus();
        return;
    }


    // var ajax = new Ajax('POST', 'php/cadastre-se.php', false);
    
    var ajax = new Ajax('POST', 'php/cadastre-se.php', false);
    
    var txtNome = document.getElementById('txtNome').value;
    var txtEmail = document.getElementById('txtEmail').value;
    var txtEstabelecimento = document.getElementById('txtEstabelecimento').value;
    var txtTelefone = document.getElementById('txtTelefone').value;
    var txtSenha = document.getElementById('txtSenha').value;

    var p='action=Gravar';


    p+='&txtNome=' + txtNome;
    p+='&txtEmail=' + txtEmail;
    p+='&txtEstabelecimento=' + txtEstabelecimento;
    p+='&txtTelefone=' + txtTelefone;
    p+='&txtSenha=' + txtSenha;

    if(confirm("Deseja salvar?")){
        alert(p);
        ajax.Request(p);

        alert(ajax.getResponseText());
        //var json = JSON.parse(ajax.getResponseText());

       if (ajax.getResponseText() == '0') {
            alert("Já existe uma conta com este email!");
            return;
        }else{
            $JQuery(".conteudo_cadastre_se").hide();
            $JQuery(".menu_cadastro").hide();
            $JQuery(".divSucesso").show();
        }
    }
}