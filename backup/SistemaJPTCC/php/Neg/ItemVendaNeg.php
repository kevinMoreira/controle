<?php

/**
 * Created by PhpStorm.
 * User: kevin_000
 * Date: 27/05/2016
 * Time: 18:35
 */
require_once('../Dao/ItemVendaDao.php');
require_once('../Ent/ItemVenda.php');

class ItemVendaNeg
{

    public function BuscarProduto( $codigoBarras){
        $itemVenda = new itemVenda();
        $itemVendaDao = new itemVendaDao();
        return $itemVendaDao->Obter($itemVenda->getProduto($codigoBarras));
    }
}