function VerificaSessao() {

    var ajax = new Ajax('POST', 'php/sistemaJP.php', false);
    var p = 'action=VerificaSessao';
    ajax.Request(p);
    if (ajax.getResponseText() === '0') {
        //alert("Seesão expirada");
        window.location = 'index.php';
    }
}

function DestroiSessao() {

    var ajax = new Ajax('POST', 'php/sistemaJP.php', false);
    var p = 'action=DestroiSessao';
    ajax.Request(p);
}

function MontaMenu() {

    var ajax = new Ajax('POST', 'php/sistemaJP.php', true);

    ajax.ajax.onreadystatechange = function() {

        if (!ajax.isStateOK())
            return;        

        document.getElementById('menu').innerHTML += ajax.getResponseText();
    };

    var p = 'action=MontaMenu';
    ajax.Request(p);
}

function getDadosUsuario(){

    var ajax = new Ajax('POST', 'php/sistemaJP.php', true);

    ajax.ajax.onreadystatechange = function() {

        if (!ajax.isStateOK())
            return;

        document.getElementById('nome_usuario').innerHTML += ajax.getResponseText();
    };

    var p = 'action=getDadosUsuario';
    ajax.Request(p);
}