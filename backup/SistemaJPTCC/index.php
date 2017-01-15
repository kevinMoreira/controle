<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SistemaJP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/index.css" />
    <script type="text/javascript" src="js/json.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
    <script type="text/javascript" src="js/sistemaJP.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/spin.min.js"></script>
    <link rel="shortcut icon" href="imagens/favicon/favicon.ico" type="image/vnd.microsoft.icon">
    <script type="text/javascript">
        var $JQuery = jQuery.noConflict();
    </script>

</head>
<body>
<div id="foo" style="display:block;">


</div>
<div id="container">
    <div id="titulo"><h1>Login</h1></div>
    <div class="caixa_login">
        <form style="text-align:center">
            <p>
                <input class="campos_login" type="text" id="login" autofocus placeholder="Login"/>
                <label id="erro_email" class="error">Preencha o seu Login.</label>
            </p>
            <input class="campos_login" type="password" id="senha" placeholder="Senha" onkeydown="login_KeyDown();"/>
            <label id="erro_senha" class="error">Preencha sua senha.</label>
            <p>
                <input class="btn_index" type="button" value="Entrar" onclick="Login();"/>
            </p>
            <div>
                <input type="button" class="btn_index" value="Cadastre-se" onclick="Cadastre_se();">
            </div>
            <a href="esqueci-minha-senha.html" class="link">Esqueci minha senha</a>
        </form>
    </div>
    <div id="footer">
        <h6>©<?php echo date('Y');?> Desenvolvido por João Paulo e Kevin Rangel</h6>
    </div>

</div>

<div class="caixa_info">
    <div class="info">
        Gerencie seu negócio de forma eficiente com nossa solução em nuvem<br />
        <br />
        Cadastre-se e experimente!
    </div>
    <div class="img_info">
        <img src="imagens/economia.png">
    </div>

</div>
</body>
</html>
