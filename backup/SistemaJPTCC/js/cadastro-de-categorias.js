window.onload = function() {

    VerificaSessao();
    getDadosUsuario();
    MontaMenu();
    Desabilitar(true);
};

function Editar(){

    Desabilitar(false);

    document.getElementById('nome').focus();
    document.getElementById('novo').setAttribute('style', 'visibility:hidden');
    document.getElementById('editar').setAttribute('src', 'imagens/ok.png');
    document.getElementById('editar').setAttribute('title', 'Atualizar');
    document.getElementById('editar').setAttribute('onclick', 'Update();');
    document.getElementById('excluir').setAttribute('style', 'visibility:hidden');
    document.getElementById('pesquisar').setAttribute('src', 'imagens/close.png');
    document.getElementById('pesquisar').setAttribute('width', '50');
    document.getElementById('pesquisar').setAttribute('height', '50');
    document.getElementById('pesquisar').setAttribute('title', 'Cancelar');
    document.getElementById('pesquisar').setAttribute('onclick', 'Cancelar();');
}

function Pesquisar(){

    var pesq;

    if(pesq=prompt("Buscar categoria pelo nome ou código.")) {


        var ajax = new Ajax('POST', './php/Neg/CategoriaNeg.php', false);

        var p='action=pesquisarCategoria';
        p+='&pesq=' + pesq;

        ajax.Request(p);

        if(ajax.getResponseText()==0){
            alert("Inexistente!");
            return;
        }

        var v =ajax.getResponseText(p);

        var json = JSON.parse(v);

        if (ajax.getResponseText() == 0) {
            alert("Inexistente!");
            return;

        }

        document.getElementById('nome').value = json.nome;
        document.getElementById('codigo').value = json.idCategoria;


    }
}

function Excluir(){

    if(confirm("Deseja excluir categoria?")){

        var idCategoria = document.getElementById('codigo').value;

        var ajax = new Ajax('POST', './php/Neg/CategoriaNeg.php', false);

        var p='action=excluir';
        p+='&idCategoria=' + idCategoria;

        ajax.Request(p);

        alert("Excluído com sucesso!");

        Cancelar();

    }else{
        alert("Ufa... Foi por pouco!");
    }
}

function Novo(){

    Desabilitar(false);
    document.getElementById('nome').focus();

    document.getElementById('novo').setAttribute('src', 'imagens/ok.png');
    document.getElementById('novo').setAttribute('width', '50');
    document.getElementById('novo').setAttribute('height', '50');
    document.getElementById('novo').setAttribute('title', 'Salvar');
    document.getElementById('novo').setAttribute('onclick', 'Salvar();');//salvar

    document.getElementById('editar').setAttribute('style', 'visibility:hidden');
    document.getElementById('excluir').setAttribute('style', 'visibility:hidden');

    document.getElementById('pesquisar').setAttribute('src', 'imagens/close.png');
    document.getElementById('pesquisar').setAttribute('width', '50');
    document.getElementById('pesquisar').setAttribute('height', '50');
    document.getElementById('pesquisar').setAttribute('title', 'Cancelar');
    document.getElementById('pesquisar').setAttribute('onclick', 'Cancelar();');
}

function Desabilitar(valor){
    document.getElementById('nome').disabled = valor;
}

function Cancelar(){

    Desabilitar(true);

    document.getElementById('nome').value='';
    document.getElementById('codigo').value='';

    document.getElementById('editar').setAttribute('src', 'imagens/editar.png');
    document.getElementById('excluir').setAttribute('src', 'imagens/excluir.png');

    document.getElementById('novo').setAttribute('style', 'visibility:visible');
    document.getElementById('editar').setAttribute('style', 'visibility:visible');
    document.getElementById('excluir').setAttribute('style', 'visibility:visible');

    document.getElementById('novo').setAttribute('src', 'imagens/novo.png');
    document.getElementById('novo').setAttribute('width', '50');
    document.getElementById('novo').setAttribute('height', '50');
    document.getElementById('novo').setAttribute('title', 'Novo');
    document.getElementById('novo').setAttribute('onclick', 'Novo();');

    document.getElementById('pesquisar').setAttribute('src', 'imagens/pesquisar.png');
    document.getElementById('pesquisar').setAttribute('width', '50');
    document.getElementById('pesquisar').setAttribute('height', '50');
    document.getElementById('pesquisar').setAttribute('title', 'Pesquisar');
    document.getElementById('pesquisar').setAttribute('onclick', 'Pesquisar();');

    document.getElementById('editar').setAttribute('src', 'imagens/editar.png');
    document.getElementById('editar').setAttribute('width', '50');
    document.getElementById('editar').setAttribute('height', '50');
    document.getElementById('editar').setAttribute('title', 'Editar');
    document.getElementById('editar').setAttribute('onclick', 'Editar();');
}

function Salvar(){

    var ajax = new Ajax('POST', './php/Neg/CategoriaNeg.php', false);

    var nome = document.getElementById('nome').value;

    var p='action=salvarCategoria';

    p+='&nome=' + nome;

    if(confirm("Deseja salvar?")){
        ajax.Request(p);
        Cancelar();
        alert("Gravado com sucesso!");
    }


}

function Update(){

    if(confirm("Deseja atualizar?")){

        var ajax = new Ajax('POST', './php/Neg/CategoriaNeg.php', false);
        var idCategoria = document.getElementById('codigo').value;
        var nome = document.getElementById('nome').value;
        var p='action=editarCategoria';

        p+='&idCategoria=' + idCategoria;
        p+='&nome=' + nome;

        ajax.Request(p);
        Cancelar();
        alert("Atualizado com sucesso!");
    }
}

