window.onload = function () {

    VerificaSessao();
    getDadosUsuario();
    MontaMenu();
    Mask.setCPF(document.getElementById('cpf'));
    Menu();
    Desabilitar(true);
    carregaDep();
};

function carregaDep() {
    var combo = document.getElementById('departamento');
    var ajax = new Ajax('POST', 'php/cadastro-de-usuarios.php', false);
    var p = 'action=carregaDep';

    ajax.Request(p);

    var json = JSON.parse(ajax.getResponseText());
    
    combo.options[0] = new Option("SELECIONE");

    for (var i = 0; i < json.length; i++) {
        combo.options[i + 1] = new Option(json[i].nome, json[i].idDepartamento);
    }
}

function MudaStatus() {

    if (document.getElementById('status').value == 1) {

        document.getElementById('status').value = 0;
        document.getElementById('status').setAttribute('title', 'Desativado');

    } else {

        document.getElementById('status').value = 1;
        document.getElementById('status').setAttribute('title', 'Ativo');

    }
}

function Menu() {

    var ajax = new Ajax('POST', 'php/cadastro-de-usuarios.php', false);

    var p = 'action=menu';

    ajax.Request(p);

    var json = JSON.parse(ajax.getResponseText());

    var json2;

    var menu = document.getElementById('permissoes');//seleciona div

    for (var i = 0; i < json.length; i++) {

        var checkbox = DOM.newElement('input', json[i].id_menu);
        checkbox.setAttribute('type', 'checkbox');
        checkbox.setAttribute('name', 'item');
        //checkbox.setAttribute('onclick','mostra("div", ' +  json[i].id_submenu + ', ' + json[i].id_menu + ');');

        var label2 = DOM.newElement('label');
        label2.innerHTML = json[i].nome_menu + "<br><br>";
        label2.setAttribute('style', 'margin-left: 10px');
        menu.appendChild(checkbox);

        menu.appendChild(label2);

        if (json[i].id_submenu !== null) {//verifica se há submenu para não ficar criando header nos cliques

            var ajax2 = new Ajax('POST', 'php/cadastro-de-usuarios.php', false);

            var q = 'action=subMenu';

            q += '&id_menu=' + json[i].id_menu;

            ajax2.Request(q);

            json2 = JSON.parse(ajax2.getResponseText());

            var submenu = DOM.newElement('div', "div" + json[i].id_submenu);
            //submenu.setAttribute('style', 'display:none');
            document.getElementById('permissoes').appendChild(submenu);

            for (var j = 0; j < json2.length; j++) {

                var checkbox2 = DOM.newElement('input', json2[j].id_submenu);
                checkbox2.setAttribute('type', 'checkbox');
                checkbox2.setAttribute('name', 'sub_item');
                checkbox2.setAttribute('style', 'margin-left:50px');
                checkbox2.setAttribute('value', json2[j].id_submenu);

                var label = DOM.newElement('label');
                label.innerHTML = json2[j].nome_submenu + "<br><br>";
                label.setAttribute('style', 'margin-left:10px');
                submenu.appendChild(checkbox2);
                submenu.appendChild(label);
            }
        }
    }
}

function Editar() {

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

function Pesquisar() {

    var pesq;
    if (pesq = prompt("Buscar usuário pelo nome, telefone ou cpf.")) {

        var ajax = new Ajax('POST', 'php/cadastro-de-usuarios.php', false);

        var p = 'action=pesquisarUsuario';
        p += '&pesq=' + pesq;

        ajax.Request(p);

        if (ajax.getResponseText() == 0) {
            alert("Inexistente!");
            return;
        }

        var json = JSON.parse(ajax.getResponseText());
        var combo = document.getElementById('departamento');

        document.getElementById('nome').value = json[0].nome;
        document.getElementById('cpf').value = json[0].cpf;
        document.getElementById('data_nascimento').value = json[0].data_nascimento;
        document.getElementById('telefone').value = json[0].telefone;
        document.getElementById('celular').value = json[0].celular;
        document.getElementById('email').value = json[0].email;
        document.getElementById('cep').value = json[0].cep;
        document.getElementById('endereco').value = json[0].endereco;
        document.getElementById('numero').value = json[0].numero;
        document.getElementById('complemento').value = json[0].complemento;
        document.getElementById('bairro').value = json[0].bairro;
        document.getElementById('cidade').value = json[0].cidade;
        document.getElementById('uf').value = json[0].uf;
        document.getElementById('login').value = json[0].login;
        document.getElementById('senha').value = json[0].senha;
        document.getElementById('status').value = json[0].status;
        document.getElementById('codigo').value = json[0].id_usuario;
        combo.options[0] = new Option(json[0].nomeDepartamento, json[0].idDepartamento);

        var q = 'action=pesquisarMenuUsuario';
        q += '&id_usuario=' + json[0].id_usuario;

        var r = 'action=pesquisarSubMenuUsuario';
        r += '&id_usuario=' + json[0].id_usuario;

        ajax.Request(q);

        json = JSON.parse(ajax.getResponseText());

        document.getElementById('permissoes').setAttribute('style', 'display:block');

        var chk = document.getElementsByName('item');
        //var x='action=menu';
        //ajax.Request(x);
        var id_menu, id_submenu, nome;

        for (var i = 0; i < json.length; i++) {
            nome = json[i].nome;
            id_menu = json[i].id_menu;
            id_submenu = json[i].id_submenu;
            for (var j = 0; j < chk.length; j++) {
                if (id_menu == chk[j].id) {
                    chk[j].checked = true;

                    //json2 = JSON.parse(ajax.getResponseText());
                }
            }
        }

        ajax.Request(r);

        json = JSON.parse(ajax.getResponseText());

        var chk2 = document.getElementsByName('sub_item');

        for (var i = 0; i < json.length; i++) {
            for (var j = 0; j < chk2.length; j++) {
                if (json[i].id_submenu == chk2[j].id)
                    chk2[j].checked = true;
            }
        }
    }
}

function Excluir() {

    if (confirm("Deseja excluir usuário?")) {

        var id_usuario = document.getElementById('codigo').value;

        var ajax = new Ajax('POST', 'php/cadastro-de-usuarios.php', false);

        var p = 'action=excluir';
        p += '&id_usuario=' + id_usuario;

        ajax.Request(p);

        alert("Excluído com sucesso!");

        Cancelar();

    } else {
        alert("Ufa... Foi por pouco!");
    }
}

function Novo() {

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
    //document.getElementById('permissoes').setAttribute('style','display:block');
    $JQuery("#permissoes").slideDown(2000);
}

function Desabilitar(valor) {

    document.getElementById('nome').disabled = valor;
    document.getElementById('cpf').disabled = valor;
    document.getElementById('data_nascimento').disabled = valor;
    document.getElementById('telefone').disabled = valor;
    document.getElementById('celular').disabled = valor;
    document.getElementById('email').disabled = valor;
    document.getElementById('cep').disabled = valor;
    document.getElementById('endereco').disabled = valor;
    document.getElementById('numero').disabled = valor;
    document.getElementById('complemento').disabled = valor;
    document.getElementById('bairro').disabled = valor;
    document.getElementById('cidade').disabled = valor;
    document.getElementById('uf').disabled = valor;
    document.getElementById('login').disabled = valor;
    document.getElementById('senha').disabled = valor;
    document.getElementById('departamento').disabled = valor;

    if (valor == true) {
        document.getElementById('titulo').setAttribute('style', 'display:none');
        document.getElementById('permissoes').setAttribute('style', 'display:none');
        //$JQuery("#permissoes").slideUp(2000);
    } else {
        document.getElementById('titulo').setAttribute('style', 'display:block');
    }
}

function Cancelar() {

    Desabilitar(true);

    document.getElementById('nome').value = '';
    document.getElementById('cpf').value = '';
    document.getElementById('data_nascimento').value = '';
    document.getElementById('telefone').value = '';
    document.getElementById('celular').value = '';
    document.getElementById('email').value = '';
    document.getElementById('cep').value = '';
    document.getElementById('endereco').value = '';
    document.getElementById('numero').value = '';
    document.getElementById('complemento').value = '';
    document.getElementById('bairro').value = '';
    document.getElementById('cidade').value = '';
    document.getElementById('uf').value = '';
    document.getElementById('login').value = '';
    document.getElementById('senha').value = '';
    document.getElementById('codigo').value = '';
    document.getElementById('departamento').value = '';

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

function Salvar() {

    var ajax = new Ajax('POST', 'php/cadastro-de-usuarios.php', false);

    var nome = document.getElementById('nome').value;
    var departamento = document.getElementById('departamento').value;
    var cpf = document.getElementById('cpf').value;
    var data_nascimento = document.getElementById('data_nascimento').value;
    var telefone = document.getElementById('telefone').value;
    var celular = document.getElementById('celular').value;
    var email = document.getElementById('email').value;
    var cep = document.getElementById('cep').value;
    var endereco = document.getElementById('endereco').value;
    var numero = document.getElementById('numero').value;
    var complemento = document.getElementById('complemento').value;
    var bairro = document.getElementById('bairro').value;
    var cidade = document.getElementById('cidade').value;
    var uf = document.getElementById('uf').value;
    var login = document.getElementById('login').value;
    var senha = document.getElementById('senha').value;
    var status = document.getElementById('status').value;
    var chk = document.getElementsByName('item');
    var chk2 = document.getElementsByName('sub_item');

    var menu = '';
    var subMenu = '';

    for (var i = 0; i < chk.length; i++) {

        if (chk[i].checked == true) {

            if (menu === '')
                menu = chk[i].id + ",";
            else
                menu += chk[i].id + ",";
        }
    }

    for (var i = 0; i < chk2.length; i++) {

        if (chk2[i].checked == true) {

            if (subMenu === '')
                subMenu = chk2[i].id + ",";
            else
                subMenu += chk2[i].id + ",";
        }

    }


    var p = 'action=salvarUsuario';
    var q = 'action=salvarMenu';

    p += '&nome=' + nome;
    p += '&cpf=' + cpf;
    p += '&data_nascimento=' + data_nascimento;
    p += '&telefone=' + telefone;
    p += '&celular=' + celular;
    p += '&email=' + email;
    p += '&cep=' + cep;
    p += '&endereco=' + endereco;
    p += '&numero=' + numero;
    p += '&complemento=' + complemento;
    p += '&bairro=' + bairro;
    p += '&cidade=' + cidade;
    p += '&uf=' + uf;
    p += '&login=' + login;
    p += '&senha=' + senha;
    p += '&status=' + status;
    p += '&idDepartamento=' + departamento;

    q += '&menu=' + menu;
    q += '&subMenu=' + subMenu;

    if (confirm("Deseja salvar?")) {
        ajax.Request(p);
        ajax.Request(q);
        Cancelar();
        alert("Gravado com sucesso!");
    }
}

function Update() {

    if (confirm("Deseja atualizar?")) {

        var ajax = new Ajax('POST', 'php/cadastro-de-usuarios.php', false);

        var nome = document.getElementById('nome').value;
        var cpf = document.getElementById('cpf').value;
        var data_nascimento = document.getElementById('data_nascimento').value;
        var telefone = document.getElementById('telefone').value;
        var celular = document.getElementById('celular').value;
        var email = document.getElementById('email').value;
        var cep = document.getElementById('cep').value;
        var endereco = document.getElementById('endereco').value;
        var numero = document.getElementById('numero').value;
        var complemento = document.getElementById('complemento').value;
        var bairro = document.getElementById('bairro').value;
        var cidade = document.getElementById('cidade').value;
        var uf = document.getElementById('uf').value;
        var login = document.getElementById('login').value;
        var senha = document.getElementById('senha').value;
        var status = document.getElementById('status').value;
        var id_usuario = document.getElementById('codigo').value;
        var departamento = document.getElementById('departamento').value;

        var chk = document.getElementsByName('item');
        var chk2 = document.getElementsByName('sub_item');

        var menu = '';
        var subMenu = '';

        for (var i = 0; i < chk.length; i++) {

            if (chk[i].checked == true) {

                if (menu === '')
                    menu = chk[i].id + ",";
                else
                    menu += chk[i].id + ",";
            }
        }

        for (var i = 0; i < chk2.length; i++) {

            if (chk2[i].checked == true) {

                if (subMenu === '')
                    subMenu = chk2[i].id + ",";
                else
                    subMenu += chk2[i].id + ",";
            }
        }

        var p = 'action=editarUsuario';
        var q = 'action=editarMenu';

        p += '&nome=' + nome;
        p += '&cpf=' + cpf;
        p += '&data_nascimento=' + data_nascimento;
        p += '&telefone=' + telefone;
        p += '&celular=' + celular;
        p += '&email=' + email;
        p += '&cep=' + cep;
        p += '&endereco=' + endereco;
        p += '&numero=' + numero;
        p += '&complemento=' + complemento;
        p += '&bairro=' + bairro;
        p += '&cidade=' + cidade;
        p += '&uf=' + uf;
        p += '&login=' + login;
        p += '&senha=' + senha;
        p += '&status=' + status;
        p += '&id_usuario=' + id_usuario;
        p += '&idDepartamento=' + departamento;

        q += '&menu=' + menu;//Envia vetor com as opções de permissão do usuário
        q += '&subMenu=' + subMenu;//Envia vetor com as opções de permissão do usuário
        q += '&id_usuario=' + id_usuario;

        ajax.Request(p);
        ajax.Request(q);

        Cancelar();

        window.location = 'cadastro-de-usuarios.html';

        alert("Atualizado com sucesso!");
    }
}

