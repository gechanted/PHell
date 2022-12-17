<?php

namespace PHell\Tests\Ops;

use PHell\Flow\Data\Data\Arra;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Main\Code;
use PHell\Operators\ArrayOperator;
use PHell\Operators\Assign;
use PHell\Operators\ExecuteFunction;
use PHell\Operators\GetFunctionCollection;
use PHell\Operators\Variable;
use PHell\PHell;

class ArrayTester
{

}

require_once __DIR__ . '/../../../vendor/autoload.php';

$var = new Variable('var');
$phell = new PHell();
$phell->execute(new Code([
    new Assign($var, new Arra([new Strin('hello'), new Strin('world')])),
    new Assign(new ArrayOperator($var), new Strin('1234')),
    new ExecuteFunction(new GetFunctionCollection('echo'), [new ExecuteFunction(new GetFunctionCollection('dump'), [$var])]),
    new Assign(new ArrayOperator($var, new Intege(0)), new Strin('no hello')),
    new ExecuteFunction(new GetFunctionCollection('echo'), [new ExecuteFunction(new GetFunctionCollection('dump'), [$var])]),
]));

