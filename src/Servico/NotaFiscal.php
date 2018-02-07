<?php

namespace AgendarEntrega\Servico;

use \AgendarEntrega\Transport;

interface NotaFiscalInterface {
    public function aprovarNFE($chave);
    public function recusarNFE($chave, $motivo);
}

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
        $res = $this->client->post("/nota-fiscal/notas/$chave/recusar-recebimento", [
            "motivo" => $motivo,
        ]);
        return $this->client->validResponse($res);
    }
}
