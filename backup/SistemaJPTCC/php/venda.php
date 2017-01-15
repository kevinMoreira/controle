




<!--CÓDIGO NÃO UTILIZADO





<!-- <html>
    <head>
        <link href="../css/Estilo.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            function ola() {
                window.location("consulta_cliente.php");
            }
        </script>
    </head>
    <body>
        <?php
        include 'sistemaJP.php';

        $conexao = AbreBancoJP();

        $cont = 0;

        $select = "select * from categoria order by idCategoria";
        $query = mysql_query($select, $conexao);

        $tabela = "<form id='form' action='select_prod_cat.php' method='post'><table border='1px' align='center' id='tabela' cellpadding='15px'><tr>";

        while ($row = mysql_fetch_row($query)) {
            $tabela .= "<td><a href='#'>" . $row[1] . "</a></td><td><input type='checkbox' name='id[]' value='$row[0]'></td>";
            if ($cont % 2 == 1)
                $tabela .="<tr></tr>";
            $cont++;
        }

        $tabela .= "<td colspan=4 align=center><input type='submit' value='Selecionar'></td></tr></table></form>";
        
        echo $tabela;
        ?>
    </body>

</html>
 -->