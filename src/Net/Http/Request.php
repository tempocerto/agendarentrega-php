<?php

namespace AgendarEntrega\Net\Http;

class Request {
    public $url;
    public $method;
    public $body;
    public $headers = array();

    public function __construct($url, $method) {
        $this->url = $url;
        $this->method = $method;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    public function setHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }
}
