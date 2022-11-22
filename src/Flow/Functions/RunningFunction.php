<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Exceptions\OverBreakException;
use PHell\Flow\Exceptions\OverContinueException;
use PHell\Flow\Exceptions\ReturnValueDoesntMatchType;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\CommandActions\BreakAction;
use Phell\Flow\Main\CommandActions\ContinueAction;
use Phell\Flow\Main\CommandActions\ReturnAction;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use Phell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class RunningFunction extends EasyStatement
{

    //TODO maybe add a check on transmitException if the Exceptions are in function description (warning if not)

    public function __construct(private readonly FunctionObject             $object,
                                private readonly Code                       $code,
                                private readonly DatatypeInterface $returnType)
    {
    }

    public function getReturnType(): DatatypeInterface
    {
        return $this->returnType;
    }

    public function isActive(): bool
    {
        //TODO !!!!!!!! impotent
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        foreach ($this->code->getStatements() as $statement) {
            $result = $statement->execute($this->object, $this->upper);
            if ($result->isActionRequired()) {

                $action = $result->getAction();
                if ($action instanceof ReturnAction) {
                    if ($action->getFunction() !== null && $action->getFunction() !== $this) {
                        return $result; //TODO new Returnload
                    }
                    return $this->return($action->getValue());

                } elseif ($action instanceof ContinueAction) {
                    $r = $this->upper->transmit(new OverContinueException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));

                } elseif ($action instanceof BreakAction) {
                    $r = $this->upper->transmit(new OverBreakException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));

                } elseif ($action instanceof ReturningExceptionAction) {
                    return new ExceptionReturnLoad(new ExecutionResult($action));

                    //TODO if shove action => throw exception

                } else {
                    throw new ShouldntHappenException();
                }
            }
        }

        return $this->return(new Voi());
    }

    private function return(DataInterface $value): ReturnLoad
    {
        if ($this->returnType->validate($value)) {
            return new DataReturnLoad($value);
        }
        $r = $this->upper->transmit(new ReturnValueDoesntMatchType());
        return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
    }
}