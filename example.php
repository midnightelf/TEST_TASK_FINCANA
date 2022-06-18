<?php

require 'vendor/autoload.php';

use DI\ContainerBuilder;
use FincanaTest\Traders\Payeer;

$builder = new ContainerBuilder();

$payeer = $builder->build()->get(Payeer::class);

$payeer->setPayeerId('2f38ef57-3c5f-4000-928d-12146ee1ad5c');
$payeer->setSecretKey('vSa3eoQLbktQVvXW');

var_dump($payeer->orders());
