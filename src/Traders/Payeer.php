<?php

namespace FincanaTest\Traders;

use FincanaTest\Interfaces\TradeInterface;
use FincanaTest\Interfaces\TransfererInterface;
use FincanaTest\Transferers\Curl;

class Payeer implements TradeInterface
{
    private TransfererInterface $transferer;

    public function __construct(Curl $curl)
    {
        $this->transferer = $curl;
    }
}
