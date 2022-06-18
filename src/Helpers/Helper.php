<?php

namespace FincanaTest\Helpers;

class Helper
{
    public static function currentTs(): float
    {
        return round(microtime(true) * 1000);
    }

    public static function hmacSha256(string $data, string $key): string
    {
        return hash_hmac('sha256', $data, $key);
    }
}
