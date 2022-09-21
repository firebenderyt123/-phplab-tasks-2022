<?php

namespace src\oop\app\src\Transporters;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapt;

class GuzzleAdapter implements TransportInterface
{

    protected $config;
    protected $client;
    protected $adapter;

    public function __construct()
    {
        $this->config = ['allow_redirects' => true];
        $this->client = new GuzzleClient($this->config);
        $this->adapter = new GuzzleAdapt($this->client);
    }

    public function getContent(string $url): string
    {
        $request = new Request('GET', $url);
        return $this->adapter->sendRequest($request)->getBody(true);
    }

}
