<?php

use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Operators\Plus;

require_once __DIR__ . '/../phell.php';

$f = new Floa(7.4);
$i = new Intege(7);
var_dump(Plus::n($f,$i)->getValue());

