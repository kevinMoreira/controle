<?php
class categoria{
	private $nome;
        
        function __construct($nome) {
            $this->nome = $nome;
        }

        function getNome() {
            return $this->nome;
        }

        function setNome($nome) {
            $this->nome = $nome;
        }	
    }
?>