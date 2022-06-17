<?php

namespace FincanaTest\Traders;

use Exception;
use FincanaTest\Interfaces\TradeInterface;
use FincanaTest\Interfaces\TransfererInterface;
use FincanaTest\Transferers\Curl;

class Payeer implements TradeInterface
{
    const TradeURL = 'https://payeer.com/api/trade/';

    private TransfererInterface $transferer;
    private string $reqError;

    public function __construct(Curl $curl)
    {
        $this->transferer = $curl;
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
        $method = $this->transferer->setUrl(self::TradeURL . $method);

        $args = array_merge(compact('method'), $args);

        $res = $method->post($args);

        if ($res['success'] !== true) {
            $this->reqError = $res['error'];

            throw new Exception($res['error']['code']);
        }

        return $res;
    }
}
