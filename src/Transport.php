<?php

namespace AgendarEntrega;

use \AgendarEntrega\Net\Http\AbstractClient;
use \AgendarEntrega\Net\Http\Constants;
use \AgendarEntrega\Net\Http\Request;

class Transport extends AbstractClient {
    private $headers;
    private $baseUri;

    public function __construct($baseUri, $headers) {
        $this->baseUri = $baseUri;
        $this->headers = $headers;
    }

    public function get($url) {
        $request = new Request($this->baseUri . $url, Constants::GET);
        return $this->internalDo($request);
    }

    public function post($url, $body = null) {
        $request = new Request($this->baseUri . $url, Constants::POST);
        if (!$body) {
            $body = array();
        }
        $request->setBody(json_encode($body, JSON_FORCE_OBJECT))
            ->setHeader('Content-Type', 'application/json;charset=UTF-8');
        return $this->internalDo($request);
    }

    private function internalDo(Request $request) {
        foreach ($this->headers as $key => $value) {
            $request->setHeader($key, $value);
        }
        $resp = $this->doRequest($request);
        if (!$this->validResponse($resp)) {
            $body = $resp->asJson();
            throw new \Exception($body['message'], $resp->getStatusCode());
        }
        return $resp;
    }

    public function validResponse($response) {
        $statusCode = $response->getStatusCode();
        return $statusCode >= 200 && $statusCode <= 299;
    }
}
