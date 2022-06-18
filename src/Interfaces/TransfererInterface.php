<?php

namespace FincanaTest\Interfaces;

interface TransfererInterface
{
    /**
     * Send HTTP GET request with set parameters
     *
     * @return string|false
     */
    public function get();

    /**
     * Send HTTP POST request with set parameters
     *
     * @param array|string $args POST array or json string
     *
     * @return string|false
     */
    public function post($args);

    /**
     * Set option for request
     *
     * @param int   $option
     * @param mixed $value
     *
     * @return void
     */
    public function setOption(int $option, mixed $value);

    /**
     * Set header for request
     *
     * @param string $header
     * @param string $val
     *
     * @return void
     */
    public function setHeader(string $header, string $val);

    /**
     * Set URL for request
     *
     * @param string $url Request URL
     *
     * @return self
     */
    public function setUrl(string $url): self;
}
