var tableNota = new Table('tableNota');

window.onload = function () {

    VerificaSessao();
    getDadosUsuario();
    MontaMenu();
    document.getElementById('codigo').focus();

    tableNota.addHeader([
        DOM.newText('Item'),
        DOM.newText('Codigo'),
        DOM.newText('Nome'),
        DOM.newText('Qtde'),
        DOM.newText('Preco'),
        DOM.newText('SubTotal'),
    ]);

    tableNota.table.setAttribute('cellspacing', '10px');
    tableNota.table.setAttribute('style', 'font-size: 20px;');

    document.getElementById('nota').appendChild(tableNota.table);
}

//rolagem automática na div 
function rolarDivAuto() {
    var c = document.getElementById("nota");
    c.scrollTop = c.scrollHeight;
}

//Trata o enter para a utilização do leitor Optico
function eventoTeclado(num) {
    ev = window.event || ev;
    var keyCode = ev.keyCode || ev.which;

    if (keyCode === 32 && num === 1) {

        document.getElementById('qtde').value = '';
        document.getElementById('qtde').focus();

    }

    if (keyCode === 13 && num === 1) {
        setDados();
        rolarDivAuto();
        document.getElementById('codigo').value = '';
        document.getElementById('qtde').value = 1;
        document.getElementById('codigo').focus();
    }

    if (keyCode === 13 && num === 2) {
        document.getElementById('codigo').focus();
    }
}

//prepara dados para nota
function setDados() {

    var ajax = new Ajax('POST', 'php/caixa.php', false);
    var codigo = document.getElementById('codigo').value;

    if(codigo == ""){
        alert("Insira o código do produto!");
        return;
    }

    var p = 'action=busca';
    p += '&pesq=' + codigo;

    ajax.Request(p);

// alert(ajax.getResponseText());
    var json = JSON.parse(ajax.getResponseText());
    var qtde =parseInt(document.getElementById('qtde').value) ;


    if(ajax.getResponseText() == "0"){
         alert("Produto inexistente!");
        return;
    }

    if (qtde > parseInt(json[0].qtde)){
        alert("Quantidade insuficiente!");
        return;
    }

    var _preco = json[0].preco;
    var _subtotal = _preco * qtde;
    var getTotal = 0;
    var setTotal = 0;

    // if (codigo === '') {VALIDACAO ESTÁ AGORA SENDO FEITA NO CÓDIGO ACIMA
    //     alert("Código do produto é necessário!");
    // } else if (json[0].nome === null || json[0].nome == "0") {
    //     alert("Esse produto não está cadastrado!");
    // } else {

        _subtotal = _subtotal.toFixed(2);//delimitando casas depois da virgula
        _subtotal = parseFloat(_subtotal);

        getTotal = document.getElementById('total').value;

        //faz=se a leitura do campo total e verifica se há um valor, se não houver, 
        //acrescenta-se o valor do subtotal logo de primeira, caso contrário faz-se a 
        //soma do valor contido no campo com o respectivo subtotal atual; resultando o total
        if (getTotal !== '') {

            getTotal = getTotal.replace('R$ ', '');//elimina-se R$ com replace
            getTotal = parseFloat(getTotal);
            setTotal = _subtotal + getTotal;//com isso elimina-se a necessidade de uma variavel global.
            //alert(typeof(setTotal));Mostra o tipo da variável
        } else {
            setTotal = _subtotal;//caso o campo total esteja vazio atribui o subtotal
        }

        setTotal = setTotal.toFixed(2);
        setTotal = parseFloat(setTotal);

        document.getElementById('nome').innerHTML = json[0].nome;
        document.getElementById('preco').value = "R$ " + _preco;
        document.getElementById('subtotal').value = "R$ " + _subtotal;
        document.getElementById('total').value = "R$ " + setTotal;

        setDadosNota(qtde, _preco, codigo, json[0].nome, tableNota, _subtotal);
   
}

function numItem() {
    var idItem = 0;
    var table = $JQuery('#tableNota');

    table.find('tr').each(function () {
        $JQuery(this).find('td').eq(0).each(function () {
            idItem = $JQuery(this).text();
        });
    });
    return parseInt(idItem) + 1;
}

function setDadosNota(qtde, preco, codigo, nome, tableNota, subtotal) {
    var idItem = numItem();//adiciona o numero do item

    tableNota.addRow([
        DOM.newText(idItem),//adiciona o numero do item
        DOM.newText(codigo),
        DOM.newText(nome),
        DOM.newText(qtde + "x"),
        DOM.newText("R$ " + preco),
        DOM.newText("R$ " + subtotal),
    ]);

    document.getElementById('nota').appendChild(tableNota.table);
}
