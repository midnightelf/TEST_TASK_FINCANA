<?php

namespace FincanaTest\Helpers;

class PayeerHelper extends Helper
{
    public static function generateSign(array $args, string $key): string
    {
        $method = $args['method'];
        $post = json_encode($args['post']);

        $data = $method . $post;

        return self::hmacSha256($data, $key);
    }

    public static function encodeArrayMerge(...$args): string
    {
        return json_encode(array_merge_recursive(...$args));
    }

    public static function arrayMergeWithTs(...$args): array
    {
        return array_merge_recursive(self::postFormatTs(), ...$args);
    }

    public static function encodedPostTs(): string
    {
        $post = self::postFormatTs();

        return json_encode($post);
    }

    private static function postFormatTs(): array
    {
        $ts = ['ts' => intval(static::currentTs())];

        $post = ['post' => $ts];

        return $post;
    }
}
