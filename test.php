<?php

use PHell\Commands\TryCatch\TryConstruct;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\Code;
use PHell\Tests\Ops\DumpTester;
use PHell\Tests\Ops\FakeRunningFunction;

require_once __DIR__ . '/vendor/autoload.php';

$dt = new DumpTester();
$dump = new Dump($dt);
var_dump($dump->getValue(new FakeRunningFunction(), new TryConstruct(new Code()))->getData()->v());