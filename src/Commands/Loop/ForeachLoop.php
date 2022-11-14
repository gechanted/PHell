<?php
namespace PHell\Commands\Loop;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\DatatypeValidators\ArrayTypeValidator;
use PHell\Flow\Exceptions\ForeachStatementNotArrayException;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyCommand;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;
use PHell\Operators\Variable;

class ForeachLoop extends EasyCommand
{
    public function __construct(
        private readonly Statement $array,
        private readonly Variable  $keyVariable,
        private readonly Variable  $valueVariable,
        private readonly Code      $code)
    {
    }

    protected function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        $RL = $this->array->getValue($currentEnvironment, $this->upper);
        if ($RL instanceof ExceptionReturnLoad) { return $RL->getExecutionResult(); }
        if ($RL instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

        $validator = new ArrayTypeValidator();
        $value = $RL->getData();
        if ($validator->validate($value)->isSuccess() === false) {
            $exceptionResult = $this->upper->transmit(new ForeachStatementNotArrayException($value));
            if ($exceptionResult instanceof ExceptionHandlingResultNoShove) {
                return new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), $exceptionResult->getExecutionResult()));
            }
            if ($exceptionResult instanceof ExceptionHandlingResultShove === false) {
                throw new ShouldntHappenException();
            }
            $shoveValue = $exceptionResult->getShoveBackValue();
            if ($validator->validate($shoveValue)->isSuccess()) {
                $value = $shoveValue->v();
            }
        }

        if (is_array($value->v()) === false) {
            return new ExecutionResult();
        }

        foreach ($value->v() as $key => $item) {

            $this->valueVariable->set($currentEnvironment, $item);

            $this->keyVariable->set($currentEnvironment, $key);

        }
    }
}