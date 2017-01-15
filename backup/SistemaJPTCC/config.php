<?php

class Config {

    /*private $endereco = 'localhost';
    private $login = 'u919637772_root';
    private $pass = '64178406';
    private $banco = 'u919637772_estoq';*/

    private $endereco = 'localhost';
    private $login = 'root';
    private $pass = '';
    private $banco = 'estoque';

    public static $conn;

    function get_host() {
        return $this->endereco;
    }

    function get_login() {
        return $this->login;
    }

    function get_pass() {
        return $this->pass;
    }

    function get_banco() {
        return $this->banco;
    }

    public function connPDO(){
        $conn = new PDO("mysql:host=$this->endereco;dbname=$this->banco",
            $this->login, $this->pass);
        return $conn;
    }
}

?>
