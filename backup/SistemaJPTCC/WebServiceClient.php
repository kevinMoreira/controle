<?php

include("nusoap/lib/nusoap.php");

$cliente = new nusoap_client("http://jpe.bl.ee/WebService.php?wsdl");

$parametros = array('a'=>'aaa');

$resultado = $cliente->call('Teste',$parametros);

echo utf8_encode($resultado);

?>
