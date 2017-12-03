<?php

namespace Tests;

use Arth\Utils\Race\Preventer;

require __DIR__ . '/../vendor/autoload.php';

$race = Preventer::get();
echo getmypid() . ": " . get_class($race) . " class used for race prevention" . PHP_EOL;
echo getmypid() . ">: Before enter critical section" . PHP_EOL;
if ($race->lock('payment for 12')) {
  // critical section
  echo getmypid() . ":> Inside critical section" . PHP_EOL;
  usleep(300000);
  echo getmypid() . ":< Before leave critical section" . PHP_EOL;
}
echo getmypid() . "<: Outside of critical section" . PHP_EOL;

# run script
# for i in {1..5}; do php tests/workflow.php&  done; sleep 1
