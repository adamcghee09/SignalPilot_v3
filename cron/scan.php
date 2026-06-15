<?php require __DIR__.'/../src/bootstrap.php'; $created=(new SignalPilot\Services\AppService(storage()))->scan(); echo 'Scan complete: '.count($created)." opportunities\n";
