<?php

namespace FincanaTest\Traders;

use Exception;
use FincanaTest\Helpers\PayeerHelper;
use FincanaTest\Interfaces\TradeInterface;
use FincanaTest\Interfaces\TransfererInterface;
use FincanaTest\Transferers\Curl;

class Payeer implements TradeInterface
{
    public const TRADE_URL = 'https://payeer.com/api/trade/';

    protected TransfererInterface $transferer;
    private string $reqError;
    private string $payeerId;
    private string $secretKey;

    public function __construct(Curl $curl)
    {
        $this->transferer = $curl;
    }

    public function setPayeerId(string $id)
    {
        $this->payeerId = $id;
    }

    public function setSecretKey(string $key)
    {
        $this->secretKey = $key;
    }

    public function info()
    {
        return $this->payeerPost('info');
    }

    public function orders($pair = 'BTC_USDT')
    {
        $pair = ['pair' => $pair];

        return $this->payeerPost('orders', ['post' => $pair]);
    }

    public function account()
    {
        return $this->payeerPost('account')['balances'];
    }

    public function orderCreate(array $order)
    {
        return $this->payeerPost('order_create', ['post' => $order]);
    }

    public function orderStatus(array $req)
    {
        $this->payeerPost('order_status', ['post' => $req])['order'];
    }

    public function myOrders(array $req)
    {
        $res = $this->payeerPost('my_orders', ['post' => $req]);

        return $res['items'];
    }

    public function getError(): string
    {
        return $this->reqError;
    }

    private function payeerPost(string $method, array $args = [])
    {
        $res = $this->transferer->setUrl(self::TRADE_URL . $method);

        $args = PayeerHelper::arrayMergeWithTs(compact('method'), $args);
        $sign = PayeerHelper::generateSign($args, $this->secretKey);

        $this->transferer->setOption(CURLOPT_POST, true);
        $this->transferer->setHeader('APP-ID', $this->payeerId);
        $this->transferer->setHeader('APP-SIGN', $sign);

        $post = PayeerHelper::encodeArrayMerge($args['post']);

        $res = $res->post($post);

        if (!is_null($res)) {
            if ($res['success'] !== false) {
                $this->reqError = $res['error']['code'];

                throw new Exception($this->reqError);
            }
        }

        return $res;
    }
}
