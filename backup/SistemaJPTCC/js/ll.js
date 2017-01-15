$(document).ready(function () {

    var pressedShift = false;

    $JQuery(document).keydown(function (key) {

        var n = parseInt(key.which, 10);

        if (n === 16) {//tecla shift
            pressedShift = true;
            $JQuery('#codigo').blur();
        }

        switch (parseInt(key.which, 10)) {

            case 13: //tecla enter + shift
                if (pressedShift === true) {
                    realizarVenda();
                    pressedShift = false;
                } else {
                    $JQuery('#slide').slideUp(1000);
                }
                break;

            case 70: //tecla f (find) + shift
                if (pressedShift === true) {
                    consultar();
                    pressedShift = false;
                }
                break;

            case 46:// tecla delete + shift
                if (pressedShift === true) {
                    animacaoCancelar(true);
                    pressedShift = false;
                }
                break;

            case 67:// tecla c + shift
                if (pressedShift === true) {
                    calculadora();
                    pressedShift = false;
                }
                break;
        }
    });
    //Esmaece quando clica no fundo da div cancelar
    $JQuery('#fundo').click(function () {
        $JQuery('#fundo').fadeOut(1000);
        $JQuery('#div_cancelar').fadeOut(1000);
    });

    $JQuery('#finalizar').click(function () {

        realizarVenda();

    });

    $JQuery('#button_cancelar').click(function () {
        animacaoCancelar(true);
    });

    $JQuery('#calculadora').click(function () {
        calculadora();
    });

    $JQuery('#consultar').click(function () {
        consultar();
    });

    $JQuery('#id_venda_cancel').keydown(function (key) {

        var n = parseInt(key.which, 10);

        if (n === 13) {//enter
            submeterCancelamentoVenda();
        }
    });
});

//função para percorrer a tabela e trazer qtde idprod e valor
function realizarVenda() {

    var table = $JQuery('#tableNota');
    var idProduto = null;
    var qtde = null;
    var valor = null;
    var subtotal = null;

    table.find('tr').each(function () {

        //idProduto
        $JQuery(this).find('td').eq(1).each(function () {
            if (idProduto == null)
                idProduto = $JQuery(this).text();
            else
                idProduto += ',' + $JQuery(this).text();
        });

        //qtde
        $JQuery(this).find('td').eq(3).each(function () {
            if (qtde == null)
                qtde = $JQuery(this).text();
            else
                qtde += ',' + $JQuery(this).text();
        });

        //valor
        $JQuery(this).find('td').eq(4).each(function () {
            if (valor == null)
                valor = $JQuery(this).text();
            else
                valor += ',' + $JQuery(this).text();
        });

        //subtotal
        $JQuery(this).find('td').eq(5).each(function () {
            if (subtotal == null)
                subtotal = $JQuery(this).text();
            else
                subtotal += ',' + $JQuery(this).text();
        });
       ;
    });

    if (valor !== null && idProduto !== null) {

        if (confirm("Efetuar venda?")) {
            var ajax = new Ajax('POST', 'php/caixa.php', false);//funfou!!!!
            var p = 'action=criaVenda';
            
            ajax.Request(p);//cria venda
            
            var ajax2 = new Ajax('POST', 'php/caixa.php', false);
            var q = 'action=baixaEstoque';
            q += '&idProduto=' + idProduto;
            q += '&qtde=' + qtde;
            q += '&valor=' + valor;
            q += '&subtotal=' + subtotal;

            ajax2.Request(q);//cadastra item venda


            //alert(ajax2.getResponseText());
            
            limpa();//chama a função para limpar os dados contidos nas divs e inputs
            $JQuery('#slide').slideDown(1000);
        }
    } else {
        alert("Não há itens na venda!");
        $JQuery('#codigo').focus();
    }
}

//Limpa campos e divs da tela 
function limpa() {
    $JQuery('#preco').val('');
    $JQuery('#subtotal').val('');
    $JQuery('#total').val('');
    $JQuery('#nome').empty();
    $JQuery('#tableNota > tbody').empty();//limpa dados da tabela apartir da tbody, mantendo theader
    _total = 0;
    $JQuery('#id_venda_cancel').val('');
    $JQuery('#codigo').focus();
}

//Efeito esmaecer div cancelamento
function animacaoCancelar(aux) {

    if (aux === true) {
        $JQuery('#fundo').fadeIn(1000);
        $JQuery('#div_cancelar').fadeIn(1000);
        $JQuery('#id_venda_cancel').focus();
    } else {
        $JQuery('#fundo').fadeOut(1000);
        $JQuery('#div_cancelar').fadeOut(1000);
        $JQuery('#codigo').focus();
    }
}

//Efetua o cancelamento da venda (1) ou de itens (2)
function submeterCancelamentoVenda() {
    if ($JQuery('#total').val() !== '') {
        //Verifica se o cancelamento é da venda inteira ou de um ou mais itens
        if ($JQuery('#id_venda_cancel').val() === "1") {//Cancela venda
            limpa();
            animacaoCancelar(false);

            var ajax = new Ajax('POST', 'php/caixa.php', false);
            var p = 'action=criaVenda';
            p += '&cancelado=1';
            ajax.Request(p);

        } else if ($JQuery('#id_venda_cancel').val() === "2") {//cancela item
            var itens = prompt("Digite o(s) item(s) a serem cancelados:");
            submeterCancelamentoItemVenda(itens);
            subtraiValorCancelado();
            animacaoCancelar(false);
            $JQuery('#id_venda_cancel').val('');
        } else {
            alert('Valor Inválido!');
            $JQuery('#id_venda_cancel').focus();
        }
    } else {
        alert('Não há Itens de venda!');
        $JQuery('#id_venda_cancel').val('');
        animacaoCancelar(false);
    }
}

//Realiza o cancelamento de itens de venda
function submeterCancelamentoItemVenda(itens) {
    vetItens = itens.split(",");

    for (var i = 0; i < vetItens.length; i++) {

        var table = $JQuery('#tableNota');
        table.find('tr').each(function () {//percorre a tabela
            $JQuery(this).find('td').eq(0).each(function () {//percorre a tabela
                idItem = $JQuery(this).text();//pega num item atual
                if (idItem == vetItens[i]) {//verifica se é o item escolhida para ser cancelado
                    var nome = 'CANCEL ' + $JQuery(this).next('td').next('td').text();//navega até a <td> do nome do produto e concatena o cancel
                    $JQuery(this).next('td').next('td').text(nome);//atribui à <td> do nome o conteudo concatenado
                    $JQuery(this).next('td').next('td').next('td').next('td').next('td').text('0');//elimina o subtotal do produto cancelado
                };
            });
        });
    }
}

//Subtrai valor cancelado da nota
function subtraiValorCancelado() {
    var soma = 0;
    var valor;
    var valor_;
    var table = $JQuery('#tableNota');

    table.find('tr').each(function () {//percorre a tabela
        $JQuery(this).find('td').eq(5).each(function () {//percorre a 5 coluna da tabela
            if (valor == null) {
                valor = $JQuery(this).text();
            } else {
                valor += ',' + $JQuery(this).text();
            }
        });
    });

    valor = valor.split("R$ ");

    //se a compra tiver somente um  item é atribuido o zero para nao entrar valor null
    if (valor.length === 1) {
        soma = 0;
    } else {

        for (var i = 0; i < valor.length; i++) {

            valor_ = valor[i].split(",");

            //se o campo atual for igual a "" (vazio por causa de um cancelamento anterior) 
            //nessa iteração é atribuido zero para o correto funcionamento do calculo
            if (valor_[0] === "") {
                soma = parseFloat(soma) + 0;
            } else {
                soma = parseFloat(soma) + parseFloat(valor_[0]);//soma valor total
            }
        }
    }
    $JQuery('#total').val('R$ ' + parseFloat(soma).toFixed(2));//atribui valor ao campo
}

//Realiza a consulta de valor de um determinado produto pelo código
function consultar() {

    var codigo = prompt('Digite o código do produto');
    var ajax = new Ajax('POST', 'php/caixa.php', false);
    var p = 'action=busca';
    p += '&pesq=' + codigo;
    ajax.Request(p);
    var json = JSON.parse(ajax.getResponseText());

    if (codigo === '') {
        alert("Código do produto é necessário!");
    } else if (json[0].nome === null) {
        alert("Esse produto não está cadastrado!");
    } else {
        alert("Produto: " + json[0].nome + "\nValor: R$ " + json[0].preco);
    }
}

//Calcula a divisão do valor total a compra
function calculadora() {

    var total = $JQuery('#total').val();

    if (total !== '') {

        var result = prompt('Total: ' + total + ' Dividir em: ');

        if (result) {//se houver valor no campo. também não entra se der um cancelar 
            total = total.replace('R$', '');
            result = total / result;
            result = result.toFixed(2);//delimitando casas depois da virgula
            result = parseFloat(result);//convertendo o resultado do toFixed que é string para float
            alert('Valor a pagar: R$ ' + result);
        }
    } else {
        alert("Não há produto!");
        $JQuery('#codigo').focus();
    }
}