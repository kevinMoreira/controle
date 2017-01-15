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

    var pesq = 'action=listarFornecedor';

    pesq += '&pesq=' + pesquisa;

    $JQuery.post('php/listar-fornecedores.php', pesq, function (retorna) {//envia valor da variavel pelo método post

        tableListaFornecedor = new Table('tableListaFornecedor');
        tableListaFornecedor.table.setAttribute('class', 'rounded-corner');
        tableListaFornecedor.tfoot.setAttribute('class', 'rounded-corner-left');

        tableListaFornecedor.addHeader([
            DOM.newText('Codigo'),
            DOM.newText('Nome'),
            DOM.newText('CNPJ'),
            DOM.newText('Telefone'),
            DOM.newText('Cep'),
            DOM.newText('Endereço'),
            DOM.newText('N°'),
            DOM.newText('Compl'),
            DOM.newText('Bairro'),
            DOM.newText('Cidade'),
            DOM.newText('Estado'),
            DOM.newText('E-mail'),
            DOM.newText('Status')
        ]);

        var json = JSON.parse(retorna);

        for (var i = 0; i < json.length; i++) {

            if (json[i].status == 1)
                status = "Ativo";
            else
                status = "Desativado";

            tableListaFornecedor.addRow([
                DOM.newText(json[i].codigo),
                DOM.newText(json[i].nome),
                DOM.newText(json[i].cnpj),
                DOM.newText(json[i].telefone),
                DOM.newText(json[i].cep),
                DOM.newText(json[i].endereco),
                DOM.newText(json[i].numero),
                DOM.newText(json[i].complemento),
                DOM.newText(json[i].bairro),
                DOM.newText(json[i].cidade),
                DOM.newText(json[i].estado),
                DOM.newText(json[i].email),
                DOM.newText(status),
            ]);
        }

        $JQuery("#lista").html(tableListaFornecedor.table);//coloca o valor contido em tableListaFornecedor na divlista
    });
}