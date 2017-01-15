window.onload = function() {
    DestroiSessao();
    $JQuery(".campos_login").click(function(){
        $JQuery(".error").hide();
    });

    $JQuery("#login").focus(); 
};

function Login() {
    spin();
    var login = document.getElementById('login');
    if (login.value == '') {
          $JQuery("#foo").hide();
        alert("Preencha o campo login.");
        document.getElementById('erro_email').setAttribute('style','display:block');
        login.focus();
        return;
    }

    var senha = document.getElementById('senha');
    if (senha.value == '') {
          $JQuery("#foo").hide();
       alert("Preencha o campo senha.");
       document.getElementById('erro_senha').setAttribute('style','display:block');
       senha.focus();
       return;
   }

   // var ajax = new Ajax('POST', 'php/index.php', true);
    var ajax = new Ajax('POST', 'php/Neg/UsuarioNeg.php', true);
   ajax.ajax.onreadystatechange = function() {

      
    if (!ajax.isStateOK())
        return;

    if (ajax.getResponseText() == '0') {
        $JQuery("#foo").hide();
        alert("Usuário e/ou senha incorretos.");
        login.value = "";
        senha.value = "";
        login.focus();
        return;
    }

    if (ajax.getResponseText() == '1') {
        window.location = 'principal.html';
    }
};

var p = 'action=Login';
p += '&login=' + document.getElementById('login').value;
p += '&senha=' + document.getElementById('senha').value;
ajax.Request(p);


}

function Cadastre_se(){
    spin();
    window.location="cadastre-se.html";
}

function login_KeyDown(ev) {

    ev = window.event || ev;
    var keyCode = ev.keyCode || ev.which;

    if (keyCode === 13)
        Login();
}

function spin(){
    $JQuery("#foo").show();
    var opts = {
          lines: 13 // The number of lines to draw
        , length: 56 // The length of each line
        , width: 14 // The line thickness
        , radius: 42 // The radius of the inner circle
        , scale: 2.5 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#FDFDFD' // #rgb or #rrggbb or array of colors
        , opacity: 0 // Opacity of the lines
        , rotate: 32 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1 // Rounds per second
        , trail: 60 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: true // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
    }
    var target = document.getElementById('foo')
    var spinner = new Spinner(opts).spin(target);

    //var spinner = new Spinner().spin();
    //target.appendChild(spinner.el);
}

function spin2(){
    var opts = {
          lines: 13 // The number of lines to draw
        , length: 56 // The length of each line
        , width: 14 // The line thickness
        , radius: 42 // The radius of the inner circle
        , scale: 2.5 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#FDFDFD' // #rgb or #rrggbb or array of colors
        , opacity: 0 // Opacity of the lines
        , rotate: 32 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1 // Rounds per second
        , trail: 60 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: true // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
    }
    var target = document.getElementById('foo')
    var spinner = new Spinner(opts).spin();

    //var spinner = new Spinner().spin();
    //target.appendChild(spinner.el);
}