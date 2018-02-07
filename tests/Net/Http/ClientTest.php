<?php

namespace AgendarEntregaTest\Net\Http;

use PHPUnit\Framework\TestCase;
use AgendarEntrega\Net\Http\Client;

class ClientTest extends TestCase {
    private $client;

    protected function setUp() {
        $this->client = new Client();
    }

    public function testGetShouldReturnWithSuccess() {
        $res = $this->client->get('http://fakeserver:3000/posts/1');
        $this->assertEquals(200, $res->getStatusCode());
        $body = $res->asJson();
        $this->assertEquals(1, $body['id']);
    }

    public function testPostShouldSendWithSuccess() {
        $res = $this->client->post('http://fakeserver:3000/posts', array(
            'userId' => 1,
            'title' => 'foo',
            'body' => 'bar',
        ));
        $this->assertEquals(201, $res->getStatusCode());
        $body = $res->asJson();
        $this->assertGreaterThan(0, $body['id']);
    }
}
