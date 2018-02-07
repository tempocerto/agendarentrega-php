<?php

namespace AgendarEntrega\Net\Http;

class Client extends AbstractClient {
    public function get($url) {
        $req = new Request($url, Constants::GET);
        return $this->doRequest($req);
    }

    public function post($url, $body = null) {
        $req = new Request($url, Constants::POST);
        $req->setBody($body);
        return $this->doRequest($req);
    }
}
