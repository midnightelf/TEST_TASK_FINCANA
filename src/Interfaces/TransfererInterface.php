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
     * @param array $args POST body
     * 
     * @return string|false
     */
    public function post(array $args = []);

    /**
     * Set option for request
     * 
     * @param int $option
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

}
