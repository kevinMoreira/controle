<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 07/06/2015
 * Time: 17:03
 */

require_once('config.php');
class MySQL {
   /*
    var $host = 'localhost';
    var $usr = 'u919637772_root';
    var $pw  = '64178406';
    var $db  = 'u919637772_estoq';*/
   
    var $host = 'localhost';
    var $usr = 'root';
    var $pw  = '';
    var $db  = 'estoque';

    var $sql; // Query - instrução SQL
    var $conn; // Conexão ao banco
    var $resultado; // Resultado de uma consulta

    function MySQL() {
    }

    // Esta função conecta-se ao banco de dados e o seleciona.
    function connMySQL() {
        $this->conn = mysqli_connect($this->host, $this->usr, $this->pw, $this->db);
        if (!$this->conn) {
            echo "<p>Não foi possível conectar-se ao servidor MySQL.</p>\n" .
                "<p><strong>Erro MySQL: " . mysqli_connect_error() . "</strong></p>\n";
            exit();
        } elseif (!mysqli_select_db($this->conn, $this->db)) {
            echo "<p>Não foi possível selecionar o Banco de Dados desejado.</p>\n" .
                "<p><strong>Erro MySQL: " . mysqli_error($this->conn) . "</strong></p>\n";
            exit();
        }
        return $this->conn;
    }

    // Função para executar SPs (Stored Procedures). Utiliza-se a função mysqli_multi_query()
    // porque as SPs retornam mais de um conjunto de resultados e a função mysqli_query() não consegue
    // trabalhar com respostas múltiplas, ocasionando eventuais erros.
    function execSP($sql) {
        $this->connMySQL();
        $this->sql = $sql;
        $i = 0;
        $result_=null;

        if (mysqli_multi_query($this->conn, $this->sql)) {
            do {
                if ($this->resultado = mysqli_store_result($this->conn)) {
                    while ($row = mysqli_fetch_array($this->resultado)) {
                        $result_ = $row;
                    }
                    mysqli_free_result($this->resultado);
                }
                $i++;
            } while (mysqli_next_result($this->conn));
            mysqli_close($this->conn);
        } else {
            echo mysqli_error($this->conn);
            $this->closeConnMySQL();
            exit();
        }
        $this->closeConnMySQL();
        return $result_;
    }

    //Função para encerramento da conexão com o banco de dados.
    function closeConnMySQL() {
        return mysqli_close($this->conn);
    }

} 