<?php
class Produto{
    public $nome;
    public $valor;
    public $status;
    public $codigoBarras;
    public $produtoId;
    public $categoriaId;

    
    public function getCategoriaoId(){
        return $this->categoriaId;
    }

    public function setCategoriaId($categoriaId){
        $this->categoriaId=$categoriaId;
    }


    public function getProdutoId(){
        return $this->produtoId;
    }

    public function setProdutoId($produtoId){
        $this->produtoId=$produtoId;
    }

    function getNome() {
        return $this->nome;
    }

    function getValor() {
        return $this->valor;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setValor($valor) {
        $this->valor = $valor;
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

    /**
     * @return mixed
     */
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }

    /**
     * @param mixed $codigoBarras
     */
    public function setCodigoBarras($codigoBarras)
    {
        $this->codigoBarras = $codigoBarras;
    }


}