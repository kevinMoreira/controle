<?php

include("nusoap/lib/nusoap.php");

$servidor = new nusoap_server();

$servidor->configureWSDL("urn:Servidor");


function Teste($a){
	return "teste";
}


$servidor->register(
	'Teste',
	array('a' => 'xsd:string'),
	array('retorno'=>'xsd:string'),
	'urn:Servidor.exemplo',
	'urn:Servidor.exemplo',
	'rpc',
	'encoded',
	'Apenas um teste'
	);


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA )?$HTTP_RAW_POST_DATA :'';


$servidor->service($HTTP_RAW_POST_DATA);

?>