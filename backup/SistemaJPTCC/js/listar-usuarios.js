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

    var pesq = 'action=listarUsuario';

    pesq += '&pesq=' + pesquisa;

    $JQuery.post('php/listar-usuarios.php', pesq, function (retorna) {//envia valor da variavel pelo método post

        tableListaUsuario = new Table('tableListaUsuario');
        tableListaUsuario.table.setAttribute('class', 'rounded-corner');
        tableListaUsuario.tfoot.setAttribute('class', 'rounded-corner-left');

        tableListaUsuario.addHeader([
            DOM.newText('Codigo'),
            DOM.newText('Nome'),
            DOM.newText('CPF'),
            DOM.newText('Data Nasc'),
            DOM.newText('Telefone'),
            DOM.newText('Celular'),
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

            if (json[i].status_ === '1')
                status = "Ativo";
            else
                status = "Desativado";

            tableListaUsuario.addRow([
                DOM.newText(json[i].id_usuario),
                DOM.newText(json[i].nome_usuario),
                DOM.newText(json[i].cpf),
                DOM.newText(json[i].data_nascimento),
                DOM.newText(json[i].telefone),
                DOM.newText(json[i].celular),
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

        $JQuery("#lista").html(tableListaUsuario.table);//coloca o valor contido em tableListaUsuario na divlista
    });
}