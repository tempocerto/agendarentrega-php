<?php

namespace AgendarEntrega\Servico;

interface NotaFiscalInterface {
    public function aprovarNFE($chave);
    public function recusarNFE($chave, $motivo);
}
