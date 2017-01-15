window.onload = function() {

    VerificaSessao();
    getDadosUsuario();
    MontaMenu();
    Desabilitar(true);
    carregarComboBox();
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

    if(pesq=prompt("Buscar Produto pelo nome ou código.")){

        var ajax = new Ajax('POST', './php/Neg/ProdutoNeg.php', false);

        var p='action=pesquisarProduto';
        p+='&pesq=' + pesq;

        ajax.Request(p);

        if(ajax.getResponseText()==0){
            alert("Inexistente!");
            return;
        }

        var json = JSON.parse(ajax.getResponseText());
        var combo = document.getElementById('categoria');
        
        document.getElementById('nome').value=json.nome;
        document.getElementById('valorVenda').value=json.valor;
        document.getElementById('codigo').value=json.produtoId;
        document.getElementById('codigoBarras').value=json.codigoBarras;
        combo.value = json.categoriaId;
        //combo.options[0] = new Option(json.categoriaId, json.categoriaId);
    }
}

function Excluir(){

    if(confirm("Deseja excluir produto?")){
        var produtoId = document.getElementById('codigo').value;
        var ajax = new Ajax('POST', './php/Neg/ProdutoNeg.php', false);

        var p='action=excluir';
        p+='&produtoId=' + produtoId;

        ajax.Request(p);
        alert("Excluído com sucesso!");
        Cancelar();
    }else{
        alert("Ufa... Foi por pouco!");
    }
}

function Novo(){

    Desabilitar(false);
    document.getElementById('codigo').focus();

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
    document.getElementById('valorVenda').disabled = valor;
    document.getElementById('categoria').disabled = valor;
    document.getElementById('codigo').disabled = valor;
    document.getElementById('codigoBarras').disabled = valor;
}

function Cancelar(){

    Desabilitar(true);

    document.getElementById('nome').value='';
    document.getElementById('valorVenda').value='';
    document.getElementById('categoria').value='';
    document.getElementById('codigo').value='';
    document.getElementById('codigoBarras').value='';

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

    var ajax = new Ajax('POST', './php/Neg/ProdutoNeg.php', false);

    var produtoId = document.getElementById('codigo').value;
    var codigoBarras = document.getElementById('codigoBarras').value;
    var nome = document.getElementById('nome').value;

    var valorVenda = document.getElementById('valorVenda').value;
    var categoriaId = document.getElementById('categoria').value;
    
    var p='action=salvarProduto';

    p+='&produtoId=' + produtoId;
    p+='&codigoBarras=' + codigoBarras;
    p+='&nome=' + nome;
    p+='&valorVenda=' + valorVenda;
    p+='&categoriaId=' + categoriaId;

    if(confirm("Deseja salvar?")){
        ajax.Request(p);
        Cancelar();
        alert("Gravado com sucesso!");
    }
}

function Update(){

    if(confirm("Deseja atualizar?")){

        var ajax = new Ajax('POST', './php/Neg/ProdutoNeg.php', false);
        var produtoId = document.getElementById('codigo').value;
        var codigoBarras = document.getElementById('codigoBarras').value;
        var nome = document.getElementById('nome').value;
        var valorVenda = document.getElementById('valorVenda').value;
        var categoriaId = document.getElementById('categoria').value;
        var p='action=editarProduto'; 

        p+='&produtoId=' + produtoId;
        p+='&codigoBarras=' + codigoBarras;
        p+='&nome=' + nome;
        p+='&valorVenda=' + valorVenda;
        p+='&categoriaId=' + categoriaId;

        ajax.Request(p);
        Cancelar();
        alert("Atualizado com sucesso!");
    }
}

function carregarComboBox(){

    var combo = document.getElementById('categoria');
    var ajax = new Ajax('POST', './php/Neg/ProdutoNeg.php', false);
    var p='action=carregarComboBox';

    ajax.Request(p);

    if(ajax.getResponseText() != '0'){
        var json = JSON.parse(ajax.getResponseText());
        combo.options[0] = new Option ("SELECIONE");
        for (var i = 0; i < json.length; i++) {
            combo.options[i+1] = new Option (json[i].nome_categoria, json[i].id_categoria);
        }
    }else{
        combo.options[0] = new Option ("CADASTRE UMA CATEGORIA");
    }
}

