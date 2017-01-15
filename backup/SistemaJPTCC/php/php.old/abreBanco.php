               
<?php

include '../php/config.php';

function AbreBanco($host, $user, $pass, $database = '') {

    $id = mysql_connect($host, $user, $pass);

    if ($database != '')
        mysql_select_db($database, $id);

    return $id;
}

function Teste($host, $user, $pass, $database = '') {

    $id = mysqli_connect($host, $user, $pass, $database);

    // if ($database != '')
    //     mysql_select_db($database, $id);

    return $id;
}
?>