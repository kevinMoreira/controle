<?php

/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 27/05/2016
 * Time: 00:20
 */

class Venda
{
    public $idVenda;
    public $totalParcelas;
    public $subtotal;
    public $valorParcela;
    public $dataHoraCadastro;
    public $dataHoraAtualizacao;

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
    public function getValorParcela()
    {
        return $this->valorParcela;
    }

    /**
     * @param mixed $valorParcela
     */
    public function setValorParcela($valorParcela)
    {
        $this->valorParcela = $valorParcela;
    }

  
    /**
     * @return mixed
     */
    public function getTotalParcelas()
    {
        return $this->totalParcelas;
    }

    /**
     * @param mixed $totalParcelas
     */
    public function setTotalParcelas($totalParcelas)
    {
        $this->totalParcelas = $totalParcelas;
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
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * @param mixed $valorTotal
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
    }
    public $valorTotal;




}