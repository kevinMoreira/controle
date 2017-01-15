<?php
	class Produto{
			private $nome;
			private $valor;
			private $categoria;
			
                        function __construct($nome, $valor, $categoria) {
                            $this->nome = $nome;
                            $this->valor = $valor;
                            $this->categoria = $categoria;
                        }

                        function getNome() {
                            return $this->nome;
                        }

                        function getValor() {
                            return $this->valor;
                        }

                        function getCategoria() {
                            return $this->categoria;
                        }

                        function setNome($nome) {
                            $this->nome = $nome;
                        }

                        function setValor($valor) {
                            $this->valor = $valor;
                        }

                        function setCategoria($categoria) {
                            $this->categoria = $categoria;
                        }


	
	}

	
?>