<?php
const SP_ROOT=__DIR__.'/..';
if(file_exists(SP_ROOT.'/vendor/autoload.php')) require_once SP_ROOT.'/vendor/autoload.php';
spl_autoload_register(function($class){$prefix='SignalPilot\\'; if(str_starts_with($class,$prefix)){ $p=SP_ROOT.'/src/'.str_replace('\\','/',substr($class,strlen($prefix))).'.php'; if(file_exists($p)) require $p; }});
function storage(): SignalPilot\Storage\JsonStorageProvider{return new SignalPilot\Storage\JsonStorageProvider(SP_ROOT.'/storage/data',SP_ROOT.'/storage/backups');}
function e($v):string{return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function app_url(string $path=''):string{$base=rtrim(dirname($_SERVER['SCRIPT_NAME']??'/'),'/');return ($base==='/'?'':$base).'/'.$path;}
