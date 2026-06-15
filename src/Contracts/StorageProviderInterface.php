<?php
namespace SignalPilot\Contracts;
interface StorageProviderInterface{public function all(string $collection):array;public function find(string $collection,string $id):?array;public function insert(string $collection,array $record):array;public function update(string $collection,string $id,array $record):array;public function delete(string $collection,string $id):bool;public function backup(?string $collection=null):void;}
