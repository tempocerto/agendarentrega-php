<?php

namespace AgendarEntrega\Servico;

use \AgendarEntrega\Transport;

class NotaFiscal implements NotaFiscalInterface {
    private $client;

    public function __construct(Transport $client) {
        $this->client = $client;
    }

    public function aprovarNFE($chave) {
        $res = $this->client->post("/nota-fiscal/notas/$chave/aprovar-recebimento");
        return $this->client->validResponse($res);
    }

    public function recusarNFE($chave, $motivo) {
        $res = $this->client->post("/nota-fiscal/notas/$chave/recusar-recebimento", array(
            "motivo" => $motivo,
        ));
        return $this->client->validResponse($res);
    }
}
