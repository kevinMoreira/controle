<?php

/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 27/05/2016
 * Time: 17:44
 */


class itemVenda
{
        public $idItemVenda;
        public  $idVenda;
        public $idProduto;
        public  $qtd;
        public $subtotal;
        public $dataHoraCadastro;
        public $dataHoraAtualizacao;

    /**
     * @return mixed
     */
    public function getIdItemVenda()
    {
        return $this->idItemVenda;
    }

    /**
     * @param mixed $idItemVenda
     */
    public function setIdItemVenda($idItemVenda)
    {
        $this->idItemVenda = $idItemVenda;
    }

    /**
     * @return mixed
     */
    public function getDataHoraCadastro()
    {
        return $this->dataHoraCadastro;
    }

    /**
     * @param mixed $dataHoraCadastro
     */
    public function setDataHoraCadastro($dataHoraCadastro)
    {
        $this->dataHoraCadastro = $dataHoraCadastro;
    }

    /**
     * @return mixed
     */
    public function getIdVenda()
    {
        return $this->idVenda;
    }

    /**
     * @param mixed $idVenda
     */
    public function setIdVenda($idVenda)
    {
        $this->idVenda = $idVenda;
    }

    /**
     * @return mixed
     */
    public function getIdProduto()
    {
        return $this->idProduto;
    }

    /**
     * @param mixed $idProduto
     */
    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }

    /**
     * @return mixed
     */
    public function getDataHoraAtualizacao()
    {
        return $this->dataHoraAtualizacao;
    }

    /**
     * @param mixed $dataHoraAtualizacao
     */
    public function setDataHoraAtualizacao($dataHoraAtualizacao)
    {
        $this->dataHoraAtualizacao = $dataHoraAtualizacao;
    }
    
    
    
    /**
     * @return mixed
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * @param mixed $subtotal
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return mixed
     */
    public function getQtd()
    {
        return $this->qtd;
    }

    /**
     * @param mixed $qtd
     */
    public function setQtd($qtd)
    {
        $this->qtd = $qtd;
    }


    //getter e setter da classe produto
    public function getProduto()
    {
        return $this->Produto();
    }

    /**
     * @param mixed $qtd
     */


    public function setCodigo($codigoBarra)
    {
         $produto = new Produto;

        $produto->setCodigoBarras($codigoBarra);
        return $produto;
    }
    


}