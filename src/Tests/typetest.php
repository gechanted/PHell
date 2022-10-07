<?php

use PHell\Flow\Data\Data\Intege;

require_once __DIR__ . '/../phell.php';

$int = new Intege(4);
var_dump($int->getInt(), $int->getFloat(), $int->getString());