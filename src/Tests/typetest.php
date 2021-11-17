<?php

use PHell\Code\Datatypes\IntegerType;

require_once __DIR__ . '/../phell.php';

$int = new IntegerType(4);
var_dump($int->getInt(), $int->getFloat(), $int->getString());