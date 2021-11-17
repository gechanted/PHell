<?php

use PHell\Code\Datatypes\FloatType;
use PHell\Code\Datatypes\IntegerType;
use PHell\Code\Operators\Plus;

require_once __DIR__ . '/../phell.php';

$f = new FloatType(7.4);
$i = new IntegerType(7);
var_dump(Plus::n($f,$i)->getValue());

