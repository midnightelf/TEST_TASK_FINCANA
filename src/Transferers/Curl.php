<?php

namespace FincanaTest\Transferers;

use CurlHandle;
use FincanaTest\Interfaces\TransfererInterface;

class Curl implements TransfererInterface
{
    protected readonly CurlHandle $curl;

    public function __construct()
    {
        $this->curl = curl_init();

        $this->setDefaultOpts();
    }

    public function get()
    {
        $this->close();

        return json_decode(curl_exec($this->curl));
    }

    public function post(array $args = [])
    {
        $this->close();

        $this->setOption(CURLOPT_POSTFIELDS, $args);

        return json_decode(curl_exec($this->curl));
    }

    public function setOption(int $option, mixed $value)
    {
        curl_setopt($this->curl, $option, $value);
    }

    public function setHeader(string $header, string $val)
    {
        $this->setOption(CURLOPT_HTTPHEADER, array($header, $val));
    }

    public function setUrl(string $url): self
    {
        $this->setOption(CURLOPT_URL, $url);

        return $this;
    }

    public function close()
    {
        curl_close($this->curl);
    }

    private function setDefaultOpts()
    {
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_HEADER, false);
    }
}
