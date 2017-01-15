<?php
$params = new stdClass();
$params->parceiroId = 336759645;
$obj = array('objParams' => $params);

try {
    $client = new SoapClient('http://www.clienteuotz.com.br/webservice.php?wsdl');
    echo '<pre>';
    var_dump($client->getSaldo($obj));
    echo '</pre>';
} catch (SoapFault $s) {
    echo '<pre>';
    var_dump('ERROR: [' . $s->faultcode . '] ' . $s->faultstring);
    echo '</pre>';
} catch (Exception $e) {
    echo '<pre>';
    var_dump('ERROR: ' . $e->getMessage());
    echo '</pre>';
}
