<?php

namespace Tests;

use Arth\Utils\Race\FailException;
use Arth\Utils\Race\Preventer;

require __DIR__ . '/../vendor/autoload.php';

/*
 Box [ : ] demonstrates critical section
 Right of colon is inside critical section, left - outside
 There is always only one script inside it
*/

try {
  echo getmypid() . ' [>: ] ' . 'Before enter critical section' . PHP_EOL;
  Preventer::guard('payment for 12', static function () {
    echo getmypid() . ' [ :>] ' . 'Inside critical section' . PHP_EOL;
    usleep(300000);
    echo getmypid() . ' [ :<] ' . 'Before leave critical section' . PHP_EOL;
  });
  echo getmypid() . ' [<: ] ' . 'Outside of critical section' . PHP_EOL;
} catch (FailException $ex) {
  echo 'FailException: ', $ex->getMessage(), PHP_EOL;
}

# run script
# (for i in {1..5}; do php tests/callable.php&  done; wait) | less
