<?php

declare(strict_types=1);

use FincanaTest\Helpers\PayeerHelper;
use PHPUnit\Framework\TestCase;

final class PayeerHelperTest extends TestCase
{
    private $payeerHelper;

    protected function setUp(): void
    {
        $this->payeerHelper = new PayeerHelper();
    }

    protected function tearDown(): void
    {
        $this->payeerHelper = null;
    }

    public function testGenerateSignIsValid()
    {
        $method = 'methodName';
        $post = ['ts' => 1234567890];
        $encoded_post = json_encode($post);
        $key = 'KeykEykeYKeykEyk';

        $args = array_merge(compact('method'), ['post' => $post]);

        $hmacSha256 = hash_hmac('sha256', $method . $encoded_post, $key);

        $this->assertEquals(
            $hmacSha256,
            $this->payeerHelper->generateSign($args, $key)
        );
    }

    public function testEncodeArrayMerge()
    {
        $foo = ['foo' => 'bar'];
        $bar = ['bar' => 'foo'];

        $this->assertEquals(
            '{"foo":"bar","bar":"foo"}',
            $this->payeerHelper->encodeArrayMerge($foo, $bar),
        );
    }

    public function testArrayMergeWithTs()
    {
        $method = 'methodName';

        $excpected = [
            'post' => ['ts' => $this->payeerHelper->currentTs()],
            'method' => $method,
        ];

        $this->assertEquals(
            $excpected,
            $this->payeerHelper->arrayMergeWithTs(compact('method')),
        );
    }
}
