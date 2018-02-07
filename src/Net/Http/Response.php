<?php

namespace AgendarEntrega\Net\Http;

class Response {
    private $body;
    private $contentType;
    private $statusCode;

    public function __construct($response) {
        $this->body = $response['body'];
        $this->contentType = strtolower($response['content_type']);
        $this->statusCode = $response['http_code'];
    }

    private function parseContentType() {
        $rs = explode(';', $this->contentType, 2);
        $rs[0] = trim($rs[0]);
        if (count($rs) > 1) {
            $rs[1] = trim($rs[1]);
        }
        return $rs;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function asJson() {
        $contentType = $this->parseContentType();
        $contentType = $contentType[0];
        if ($contentType !== 'application/json') {
            throw new \Exception('Content-Type não é um application/json válido');
        }
        return json_decode($this->body, true);
    }
}
