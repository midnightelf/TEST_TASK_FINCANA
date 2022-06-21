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
        $this->close();

        $res = json_decode(curl_exec($this->curl));

        return $this->convertResponse($res);
    }

    public function post($args)
    {
        $this->close();

        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, $args);

        $res = json_decode(curl_exec($this->curl));

        $this->convertResponse($res);
    }

    public function setOption(int $option, mixed $value): void
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

    protected function close()
    {
        curl_close($this->curl);
    }

    private function convertResponse($response)
    {
        if (is_object($response)) {
            return get_object_vars($response);
        }

        return $response;
    }

    private function setDefaultOpts()
    {
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setHeader('Content-Type', 'application/json');
    }
}
