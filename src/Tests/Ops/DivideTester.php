<?php

namespace PHell\Tests\Ops;

use PHell\Flow\Data\Data\Arra;
use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Main\Code;
use PHell\Operators\ArrayOperator;
use PHell\Operators\Assign;
use PHell\Operators\Divide;
use PHell\Operators\ExecuteFunction;
use PHell\Operators\GetFunctionCollection;
use PHell\Operators\Variable;
use PHell\PHell;

class DivideTester
{

}


require_once __DIR__ . '/../../../vendor/autoload.php';

$x = new Variable('x');
$y = new Variable('y');
$z = new Variable('z');
$phell = new PHell();
$phell->execute(new Code([
    new Assign($x, new Intege(7)),
    new Assign($y, new Intege(3)),
    new Assign($z, new Divide($x, $y)),
    new ExecuteFunction(new GetFunctionCollection('echo'), [new ExecuteFunction(new GetFunctionCollection('dump'), [$z])]),

    new Assign($x, new Intege(9)),
    new Assign($y, new Intege(3)),
    new Assign($z, new Divide($x, $y)),
    new ExecuteFunction(new GetFunctionCollection('echo'), [new ExecuteFunction(new GetFunctionCollection('dump'), [$z])]),

    new ExecuteFunction(new GetFunctionCollection('echo'), [new ExecuteFunction(new GetFunctionCollection('dump'), [new Floa(2.0)])]),

    new Assign($x, new Floa(4.5)),
    new Assign($y, new Floa(1.5)), //TODO maybe make this equate to an Int?
    new Assign($z, new Divide($x, $y)),
    new ExecuteFunction(new GetFunctionCollection('echo'), [new ExecuteFunction(new GetFunctionCollection('dump'), [$z])]),

]));
