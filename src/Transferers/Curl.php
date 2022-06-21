<?php

namespace FincanaTest\Transferers;

use CurlHandle;
use FincanaTest\Helpers\ArrayHelper;
use FincanaTest\Interfaces\TransfererInterface;

class Curl implements TransfererInterface
{
    protected CurlHandle $curl;
    private array $headers;

    public function __construct()
    {
        $this->curl = curl_init();
        $this->headers = [];

        $this->setDefaultOpts();
    }

    public function get()
    {
        $this->setOption(CURLOPT_POST, false);

        $res = curl_exec($this->curl);

        return $this->convertResponse($res);
    }

    public function post($args)
    {
        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, $args);

        $res = curl_exec($this->curl);

        return $this->convertResponse($res);
    }

    public function setOption(int $option, $value): void
    {
        curl_setopt($this->curl, $option, $value);
    }

    public function setHeader(string $header, string $val): void
    {
        $header = trim($header);
        $val = trim($val);

        $this->unsetHeader($header);

        $header = "$header: $val";

        array_push($this->headers, $header);

        $this->setOption(CURLOPT_HTTPHEADER, $this->headers);
    }

    public function unsetHeader(string $header): void
    {
        $idx = ArrayHelper::startsWith($header, $this->headers);

        if ($idx !== false) {
            array_splice($this->headers, $idx, 1);
        }
    }

    public function setUrl(string $url): self
    {
        $this->setOption(CURLOPT_URL, $url);

        return $this;
    }

    private function convertResponse($response)
    {
        $response = json_decode($response, true);

        if (is_object($response)) {
            return json_encode($response);
        }

        return $response;
    }

    private function setDefaultOpts(): void
    {
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setHeader('Content-Type', 'application/json');
    }
}
