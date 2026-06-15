<?php
namespace SignalPilot\Storage;
use SignalPilot\Contracts\StorageProviderInterface;
class JsonStorageProvider implements StorageProviderInterface{
 public function __construct(private string $dataDir,private string $backupDir){is_dir($dataDir)||mkdir($dataDir,0775,true);is_dir($backupDir)||mkdir($backupDir,0775,true);} 
 private function path(string $c):string{return $this->dataDir.'/'.preg_replace('/[^a-z0-9_]/i','',$c).'.json';}
 private function read(string $c):array{$p=$this->path($c);if(!file_exists($p))file_put_contents($p,"[]");$h=fopen($p,'r');flock($h,LOCK_SH);$raw=stream_get_contents($h);flock($h,LOCK_UN);fclose($h);$d=json_decode($raw?:'[]',true);return is_array($d)?$d:[];}
 private function write(string $c,array $d):void{$p=$this->path($c);$h=fopen($p,'c+');flock($h,LOCK_EX);ftruncate($h,0);rewind($h);fwrite($h,json_encode(array_values($d),JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));fflush($h);flock($h,LOCK_UN);fclose($h);} 
 public function all(string $c):array{return $this->read($c);} public function find(string $c,string $id):?array{foreach($this->read($c) as $r)if(($r['id']??'')===$id)return $r;return null;}
 public function insert(string $c,array $r):array{$d=$this->read($c);$r['id']=$r['id']??bin2hex(random_bytes(8));$r['created_at']=$r['created_at']??date('c');$r['updated_at']=date('c');$d[]=$r;$this->write($c,$d);return $r;}
 public function update(string $c,string $id,array $r):array{$d=$this->read($c);foreach($d as &$row){if(($row['id']??'')===$id){$row=array_merge($row,$r,['id'=>$id,'updated_at'=>date('c')]);$this->write($c,$d);return $row;}}throw new \RuntimeException("Record not found: $c/$id");}
 public function delete(string $c,string $id):bool{$d=$this->read($c);$n=array_values(array_filter($d,fn($r)=>($r['id']??'')!==$id));$this->write($c,$n);return count($n)!==count($d);} 
 public function backup(?string $collection=null):void{$files=$collection?[$this->path($collection)]:glob($this->dataDir.'/*.json');$stamp=date('Ymd_His');foreach($files as $f)if(file_exists($f))copy($f,$this->backupDir.'/'.$stamp.'_'.basename($f));}
}
