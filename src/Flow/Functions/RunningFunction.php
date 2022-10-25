<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Data\DatatypeValidators\DatatypeValidatorInterface;
use PHell\Flow\Exceptions\OverContinueException;
use PHell\Flow\Exceptions\ReturnValueDoesntMatchType;
use Phell\Flow\Main\Code;
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
                                private readonly DatatypeValidatorInterface $returnType)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        foreach ($this->code->getStatements() as $statement) {
            $result = $statement->execute($this->object, $this->upper);
            if ($result->isActionRequired()) {

                $action = $result->getAction();
                if ($action instanceof ReturnAction) {
                    return $this->return($action->getValue());

                } elseif ($action instanceof ContinueAction) {
                    $r = $this->upper->transmit(new OverContinueException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));

                } elseif ($action instanceof ReturningExceptionAction) {
                    return new ExceptionReturnLoad(new ExecutionResult($action));

                    //TODO on redo command -> throw exception since it belong to loops

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