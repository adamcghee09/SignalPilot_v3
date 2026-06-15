<?php
namespace SignalPilot\Contracts;
interface BrokerInterface{public function name():string;public function placeOrder(array $order):array;public function cancelOrder(string $orderId):bool;public function getOrder(string $orderId):?array;public function getPositions():array;public function closePosition(string $positionId,array $context=[]):array;}
