$(document).ready(function () {
    VerificaSessao();
    getDadosUsuario();
    MontaMenu();
    $JQuery("#pesq").focus();
    busca();
    $JQuery("#pesq").keyup(function () {//Jquery efeito da tecla ao subir
        busca();
    });
});

function busca() {

    var pesquisa = $JQuery("#pesq").val();//pega o valor contido no input pesq que foi selecionado acima

    var pesq = 'action=listarEstoque';

    pesq += '&pesq=' + pesquisa;

    $JQuery.post('php/listar-estoque.php', pesq, function (retorna) {//envia valor da variavel pelo método post

        tableListaProduto = new Table('tableListaProduto');
        tableListaProduto.table.setAttribute('class', 'rounded-corner');
        tableListaProduto.tfoot.setAttribute('class', 'rounded-corner-left');

        tableListaProduto.addHeader([
            DOM.newText('Codigo'),
            DOM.newText('Nome'),
            DOM.newText('Categoria'),
            DOM.newText('Valor Venda'),
            DOM.newText('Quantidade'),
        ]);

        var json = JSON.parse(retorna);

        for (var i = 0; i < json.length; i++) {

            tableListaProduto.addRow([
                DOM.newText(json[i].codigo),
                DOM.newText(json[i].nome),
                DOM.newText(json[i].nomeCategoria),
                DOM.newText(json[i].valorVenda),
                DOM.newText(json[i].qtde),
            ]);
        }
        $JQuery("#lista").html(tableListaProduto.table);//coloca o valor contido em tableListaProduto na divlista
    });
}