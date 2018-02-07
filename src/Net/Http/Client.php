<?php

namespace AgendarEntrega\Net\Http;

class Request {
    public $url;
    public $method;
    public $body;
    public $headers = [];

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

abstract class AbstractClient {
    public abstract function get($url);
    public abstract function post($url, $body = null);

    private function buildHeaders($headers) {
        $rs = [];
        foreach ($headers as $k => $v) {
            $rs[] = $k . ': ' . $v;
        }
        return $rs;
    }

    protected function doRequest(Request $request) {
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($resource, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($resource, CURLOPT_CUSTOMREQUEST, $request->method);
        curl_setopt($resource, CURLOPT_URL, $request->url);
        if ($request->method != Constants::GET && $request->body) {
            curl_setopt($resource, CURLOPT_POST, true);
            curl_setopt($resource, CURLOPT_POSTFIELDS, $request->body);
        }
        if ($request->headers) {
            curl_setopt($resource, CURLOPT_HTTPHEADER, $this->buildHeaders($request->headers));
        }

        $data = curl_exec($resource);
        $info = curl_getinfo($resource);
        $error = curl_error($resource);
        $errno = curl_errno($resource);
        curl_close($resource);

        if ($data === false) {
            throw new \Exception($error, $errno);
        }
        return new Response(array_merge(['body' => $data], $info));
    }
}
