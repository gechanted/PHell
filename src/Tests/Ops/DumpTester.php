<?php

namespace PHell\Tests\Ops;

use PHell\Commands\TryCatch\TryConstruct;
use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesisParameter;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

require_once __DIR__ . '/../../../vendor/autoload.php';

class DumpTester implements Statement
{

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        throw new ShouldntHappenException();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad(
//            new Strin('Heyho')
        new FunctionObject('HeraldTheOdd', null, null, new NamedDataFunctionParenthesis(new UnknownDatatype, [new NamedDataFunctionParenthesisParameter('param1', new Strin('Egon The Squip')), new NamedDataFunctionParenthesisParameter('param2', new Intege(42))]))
        );
    }
}

$dt = new DumpTester();
$dump = new Dump($dt);
var_dump($dump->getValue(new FakeRunningFunction(), new TryConstruct(new Code()))->getData()->v());