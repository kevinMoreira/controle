<?php
class Categoria{
	public $idCategoria;
    public $nome;
    public $status;
    

        function getNome() {
            return $this->nome;
        }

        function setNome($nome) {
            $this->nome = $nome;
        }

        function getIdCategoria(){
            return $this->idCategoria;
        }

        function setIdCategoria($idCategoria){
            $this->idCategoria = $idCategoria;

        }

        /**
         * @return mixed
         */
        public function getStatus()
        {
            return $this->status;
        }

        /**
         * @param mixed $status
         */
        public function setStatus($status)
        {
            $this->status = $status;
        }



}
?>