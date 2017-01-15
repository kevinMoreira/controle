window.onload = function() {

    VerificaSessao();
    getDadosUsuario();
    MontaMenu();
    //Mask.setCPF(document.getElementById('cnpj'));
    Desabilitar(true);
};

function MudaStatus(){

    if(document.getElementById('status').value == 1){

        document.getElementById('status').value = 0;
        document.getElementById('status').setAttribute('title','Desativado');

    }else{

        document.getElementById('status').value = 1;
        document.getElementById('status').setAttribute('title','Ativo');

    }
}

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

    var pesq=prompt("Buscar fornecedor pelo nome, telefone ou cnpj.");
  
    if(pesq != null){

        var ajax = new Ajax('POST', './php/Neg/fornecedorNeg.php', false);

        var p='action=pesquisarFornecedor';
        p+='&pesq=' + pesq;


        ajax.Request(p);

        if(ajax.getResponseText()==0){
            alert("Inexistente!");
            return;
        }

        var json = JSON.parse(ajax.getResponseText());
        
        document.getElementById('nome').value=json.nome;
        document.getElementById('cnpj').value=json.cnpj;
        document.getElementById('telefone').value=json.telefone;
        document.getElementById('email').value=json.email;
        document.getElementById('cep').value=json.cep;
        document.getElementById('endereco').value=json.endereco;
        document.getElementById('numero').value=json.numero;
        document.getElementById('complemento').value=json.complemento;
        document.getElementById('bairro').value=json.bairro;
        document.getElementById('cidade').value=json.cidade;
        document.getElementById('uf').value=json.uf;
        document.getElementById('status').value=json.status;
        document.getElementById('codigo').value=json.fornecedorId;       
    }
       
}

function Excluir(){

    if(confirm("Deseja excluir usuário?")){

        var fornecedorId = document.getElementById('codigo').value;

        var ajax = new Ajax('POST', './php/Neg/fornecedorNeg.php', false);

        var p='action=excluirFornecedor';
        p+='&fornecedorId=' + fornecedorId;

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
    document.getElementById('cnpj').disabled = valor;
    document.getElementById('telefone').disabled = valor;
    document.getElementById('email').disabled = valor;
    document.getElementById('cep').disabled = valor;
    document.getElementById('endereco').disabled = valor;
    document.getElementById('numero').disabled = valor;
    document.getElementById('complemento').disabled = valor;
    document.getElementById('bairro').disabled = valor;
    document.getElementById('cidade').disabled = valor;
    document.getElementById('uf').disabled = valor;
    document.getElementById('codigo').disabled = valor;
}

function Cancelar(){

    Desabilitar(true);

    document.getElementById('nome').value='';
    document.getElementById('cnpj').value='';
    document.getElementById('telefone').value='';
    document.getElementById('email').value='';
    document.getElementById('cep').value='';
    document.getElementById('endereco').value='';
    document.getElementById('numero').value='';
    document.getElementById('complemento').value='';
    document.getElementById('bairro').value='';
    document.getElementById('cidade').value='';
    document.getElementById('uf').value='';
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

	var ajax = new Ajax('POST', './php/Neg/fornecedorNeg.php', false);

    var nome = document.getElementById('nome').value;
    var cnpj = document.getElementById('cnpj').value;
    var telefone = document.getElementById('telefone').value;
    var email = document.getElementById('email').value;
    var cep = document.getElementById('cep').value;
    var endereco = document.getElementById('endereco').value;
    var numero = document.getElementById('numero').value;
    var complemento = document.getElementById('complemento').value;
    var bairro = document.getElementById('bairro').value;
    var cidade = document.getElementById('cidade').value;
    var uf = document.getElementById('uf').value;
    var status = document.getElementById('status').value;

    var p='action=salvarFornecedor'; 

    p+='&nome=' + nome;
    p+='&cnpj=' + cnpj;
    p+='&telefone=' + telefone;
    p+='&email=' + email;
    p+='&cep=' + cep;
    p+='&endereco=' + endereco;
    p+='&numero=' + numero;
    p+='&complemento=' + complemento;
    p+='&bairro=' + bairro;
    p+='&cidade=' + cidade;
    p+='&uf=' + uf;
    p+='&status=' + status;

    if(confirm("Deseja salvar?")){

    	ajax.Request(p);
        if(ajax.getResponseText() == "1"){
            Cancelar();
            alert("Gravado com sucesso!");    
        }else{
           alert("Houve um erro, tente novamente!");  
        }
    	
    }
}

function Update(){

    if(confirm("Deseja atualizar?")){

        var ajax = new Ajax('POST', './php/Neg/fornecedorNeg.php', false);

        var nome = document.getElementById('nome').value;
        var cnpj = document.getElementById('cnpj').value;
        var telefone = document.getElementById('telefone').value;
        var email = document.getElementById('email').value;
        var cep = document.getElementById('cep').value;
        var endereco = document.getElementById('endereco').value;
        var numero = document.getElementById('numero').value;
        var complemento = document.getElementById('complemento').value;
        var bairro = document.getElementById('bairro').value;
        var cidade = document.getElementById('cidade').value;
        var uf = document.getElementById('uf').value;
        var status = document.getElementById('status').value;
        var fornecedorId = document.getElementById('codigo').value;

       
        var p='action=editarFornecedor'; 

        p+='&nome=' + nome;
        p+='&cnpj=' + cnpj;
        p+='&telefone=' + telefone;
        p+='&email=' + email;
        p+='&cep=' + cep;
        p+='&endereco=' + endereco;
        p+='&numero=' + numero;
        p+='&complemento=' + complemento;
        p+='&bairro=' + bairro;
        p+='&cidade=' + cidade;
        p+='&uf=' + uf;
        p+='&status=' + status;
        p+='&fornecedorId=' + fornecedorId;

        ajax.Request(p);
        Cancelar();
        alert("Atualizado com sucesso!");
    }
}

