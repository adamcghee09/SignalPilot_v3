<?php
namespace SignalPilot\Contracts;
interface MarketDataProviderInterface{public function quote(string $symbol):array;public function indicators(string $symbol):array;public function marketStatus():array;}
