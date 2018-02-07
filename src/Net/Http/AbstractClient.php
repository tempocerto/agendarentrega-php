<?php

namespace AgendarEntrega\Net\Http;

abstract class AbstractClient {
    public abstract function get($url);
    public abstract function post($url, $body = null);

    private function buildHeaders($headers) {
        $rs = array();
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
        return new Response(array_merge(array('body' => $data), $info));
    }
}
