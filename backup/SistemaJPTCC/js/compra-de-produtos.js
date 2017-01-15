window.onload = function() {

    VerificaSessao();
    getDadosUsuario();
    carregarComboBoxCat();
    carregarComboBoxForn();
    MontaMenu();
    Desabilitar(true);
};

function pesquisarProduto(){//carrega produto e categoria pelo código

    var ajax = new Ajax('POST', 'php/compra-de-produtos.php', false);
    var codigo = document.getElementById('codigo').value;
    var p='action=pesquisarProduto';
    var comboProd = document.getElementById('produto');
    var comboCat = document.getElementById('categoria');

    p+='&codigo=' + codigo;
    ajax.Request(p);

    var json = JSON.parse(ajax.getResponseText());
    // alert(ajax.getResponseText());
    comboProd.options[0] = new Option(json[0].nome, json[0].idProduto);
    comboCat.options[0] = new Option(json[0].nomeCategoria, json[0].idCategoria);

}

function Editar(){

    Desabilitar(false);

    document.getElementById('fornecedor').focus();
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
    document.getElementById('categoria').disabled=true;//desabilita campos que nao podem ser editados
    document.getElementById('produto').disabled=true;
    document.getElementById('codigo').disabled=true;
}

function Pesquisar(){

    var pesq;

    if(pesq=prompt("Buscar Lote pelo código.")){

        var ajax = new Ajax('POST', 'php/compra-de-produtos.php', false);
        var p='action=pesquisarCompraProduto';
        p+='&pesq=' + pesq;

        ajax.Request(p);

        if(ajax.getResponseText()==0){
            alert("Inexistente!");
            return;
        }

        var json = JSON.parse(ajax.getResponseText());

        var categoria = document.getElementById('categoria');
        categoria.options[0] = new Option (json[0].nome_categoria, json[0].id_categoria);

        var produto = document.getElementById('produto');
        produto.options[0] = new Option (json[0].nome_produto, json[0].id_produto);

        var fornecedor = document.getElementById('fornecedor');
        fornecedor.options[0] = new Option (json[0].nome_fornecedor, json[0].id_fornecedor);

        document.getElementById('qtde').value=json[0].qtde;
        document.getElementById('valorCompra').value=json[0].valorCompra;
        document.getElementById('validade').value=json[0].validade;
        document.getElementById('codigoLote').value = json[0].idLote;

    }
}

function Excluir(){

    if(confirm("Deseja excluir lote?")){

        var idLote = document.getElementById('codigoLote').value;

        var ajax = new Ajax('POST', 'php/compra-de-produtos.php', false);

        var p='action=excluir';
        p+='&idLote=' + idLote;

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

    document.getElementById('categoria').disabled = valor;
    document.getElementById('produto').disabled = valor;
    document.getElementById('fornecedor').disabled = valor;
    document.getElementById('qtde').disabled = valor;
    document.getElementById('valorCompra').disabled = valor;
    document.getElementById('validade').disabled = valor;
    document.getElementById('codigo').disabled = valor;
}

function Cancelar(){

    Desabilitar(true);

    document.getElementById('categoria').value = '';
    document.getElementById('produto').value = '';
    document.getElementById('fornecedor').value = '';
    document.getElementById('qtde').value = '';
    document.getElementById('valorCompra').value = '';
    document.getElementById('validade').value = '';
    document.getElementById('codigo').value = '';

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

    var ajax = new Ajax('POST', 'php/compra-de-produtos.php', false);
    var id_categoria = document.getElementById('categoria').value;
    var id_produto = document.getElementById('produto').value;
    var id_fornecedor = document.getElementById('fornecedor').value;
    var qtde = document.getElementById('qtde').value;
    var valorCompra = document.getElementById('valorCompra').value;
    var validade = document.getElementById('validade').value;
    var p='action=salvarCompraProduto';

    p+='&id_produto=' + id_produto;
    p+='&id_fornecedor=' + id_fornecedor;
    p+='&qtde=' + qtde;
    p+='&valorCompra=' + valorCompra;
    p+='&validade=' + validade;
    // alert(p);
    if(confirm("Deseja salvar?")){
        // alert(p);
        ajax.Request(p);

        // alert(ajax.getResponseText());

        Cancelar();
        alert("Gravado com sucesso!");
    }
}

function Update(){

    var ajax = new Ajax('POST', 'php/compra-de-produtos.php', false);
    var id_fornecedor = document.getElementById('fornecedor').value;
    var qtde = document.getElementById('qtde').value;
    var valorCompra = document.getElementById('valorCompra').value;
    var validade = document.getElementById('validade').value;
    var idLote = document.getElementById('codigoLote').value;
    var p='action=editarCompraProduto';

    p+='&id_fornecedor=' + id_fornecedor;
    p+='&qtde=' + qtde;
    p+='&valorCompra=' + valorCompra;
    p+='&validade=' + validade;
    p+='&idLote=' + idLote;

    if(confirm("Deseja atualizar?")){
        ajax.Request(p);
        // alert(p);

        // alert(ajax.getResponseText());
        Cancelar();
        alert("Atualizado com sucesso!");
    }
}

function carregarComboBoxCat(){

    var combo = document.getElementById('categoria');

    var ajax = new Ajax('POST', 'php/compra-de-produtos.php', false);

    var p='action=carregarComboBoxCat';

    ajax.Request(p);

    var json = JSON.parse(ajax.getResponseText());

    combo.options[0] = new Option ("SELECIONE");

    for (var i = 0; i < json.length; i++) {
        combo.options[i+1] = new Option (json[i].nome_categoria, json[i].id_categoria);
    }
}

function carregarComboBoxForn(){

    var combo = document.getElementById('fornecedor');

    var ajax = new Ajax('POST', 'php/compra-de-produtos.php', false);

    var p='action=carregarComboBoxForn';

    ajax.Request(p);

    var json = JSON.parse(ajax.getResponseText());

    combo.options[0] = new Option ("SELECIONE");

    for (var i = 0; i < json.length; i++) {
        combo.options[i+1] = new Option (json[i].nome, json[i].id_fornecedor);
    }
}

function CarregarComboBoxProd(){

    var combo = document.getElementById('produto');

    var id_categoria = document.getElementById('categoria').value;

    var ajax = new Ajax('POST', 'php/compra-de-produtos.php', false);

    var p='action=carregarComboBoxProd';
    p+='&id_categoria=' + id_categoria;

    ajax.Request(p);

    var json = JSON.parse(ajax.getResponseText());

    combo.options[0] = new Option ("SELECIONE");

    for (var i = 0; i < json.length; i++) {
        combo.options[i+1] = new Option (json[i].nome, json[i].id_produto);
    }
}