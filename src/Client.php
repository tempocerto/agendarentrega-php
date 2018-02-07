<?php

namespace AgendarEntrega;

use \AgendarEntrega\Servico\NotaFiscal;

class Client {
    const BASE_URI = 'https://agendarentrega.com/api';

    private $transport;

    public function __construct($accessKey, $secretKey, $baseUri = self::BASE_URI) {
        $this->transport = new Transport($baseUri, array(
            'Authorization' => "Bearer $accessKey:$secretKey",
        ));
    }

    public function getNotaFiscal() {
        return new NotaFiscal($this->transport);
    }
}

