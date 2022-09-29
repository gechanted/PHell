<?php

use PHell\Code\Operators\Plus;
use PHell\Flow\Data\Floa;
use PHell\Flow\Data\Intege;

require_once __DIR__ . '/../phell.php';

$f = new Floa(7.4);
$i = new Intege(7);
var_dump(Plus::n($f,$i)->getValue());

