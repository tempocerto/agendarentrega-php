<?php
require_once "vendor/autoload.php";

use AgendarEntrega\Client;

$accessKey = '[access key]';
$secretKey = '[secret key]';

$client = new Client($accessKey, $secretKey);
var_dump($client->getNotaFiscal()->aprovarNFE('[chave exemplo]'));
var_dump($client->getNotaFiscal()->recusarNFE('[chave exemplo]', '[descrição exemplo de recusa da nota fiscal]'));
