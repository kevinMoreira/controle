<?php

include 'sistemaJP.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'salvarCategoria':
            salvarCategoria();
            break;

        case 'pesquisarCategoria':
            pesquisarCategoria();
            break;

        case 'excluir':
            excluir();
            break;

        case 'editarCategoria':
            editarCategoria();
            break;
    }
}


//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO DO CAMPO ORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function salvarCategoria(){

    session_start();
    $conexao=AbreBancoJP();

      $sql="CALL USP_MANTER_CATEGORIAS(
                    '$_POST[nome]',
                    $_SESSION[idOrganizacao],
                    NULL,
                    1,
                    NULL,
                    0,
                    $_SESSION[codUsuario]
        )";

    mysql_query($sql, $conexao);

    mysql_close($conexao);
}

function pesquisarCategoria(){

    session_start();
    $conexao= AbreBancoJP();
   
    $sql="CALL USP_MANTER_CATEGORIAS(
                    NULL,
                    $_SESSION[idOrganizacao],
                    NULL,
                    NULL,
                    '$_POST[pesq]',
                    3,
                    $_SESSION[codUsuario]
        )";

    $sql=mysql_query($sql, $conexao);

    if(mysql_num_rows($sql) <= 0){
        echo '0';
        mysql_close($conexao);
        return;
    }

    while($row=mysql_fetch_row($sql)){

        $json[]= array(
            'id_Categoria' => $row['0'],
            'nome' => $row['1'],
         );
    }

    echo json_encode($json);
    mysql_close($conexao);
}

function excluir(){//modificar nao excluir fisicamente. Utilizar campo del
    
    session_start();
    $conexao = AbreBancoJP();

    $sql = "UPDATE categoria set status = 0 where idCategoria = '$_POST[idCategoria]' and idOrganizacao=". $_SESSION['idOrganizacao'] ." and status=1";


     $sql="CALL USP_MANTER_CATEGORIAS(
                    NULL,
                    $_SESSION[idOrganizacao],
                    $_POST[idCategoria],
                    NULL,
                    NULL,
                    2,
                    $_SESSION[codUsuario]
        )";

    mysql_query($sql,$conexao);
    mysql_close($conexao);
}


//---------------------------------------------------------------------------------------------------------
// ATUALIZADO 22/08/2014 INCLUSÃO NA CLAUSULA WHERE IDORGANIZACAO
//---------------------------------------------------------------------------------------------------------
function editarCategoria(){

    session_start();
    $conexao=AbreBancoJP();
    $sql="CALL USP_MANTER_CATEGORIAS(
                    '$_POST[nome]',
                    $_SESSION[idOrganizacao],
                    $_POST[idCategoria],
                    1,
                    NULL,
                    1,
                    $_SESSION[codUsuario]
        )";

    mysql_query($sql, $conexao);
    mysql_close($conexao);
}