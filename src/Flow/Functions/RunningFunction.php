<?php

namespace PHell\Flow\Functions;

use PHell\Code\Code;
use PHell\Code\EasyStatement;
use PHell\Code\ReturnLoad;
use PHell\Flow\Data\DatatypeValidators\DatatypeValidatorInterface;
use PHell\Flow\Exceptions\Exception;

class RunningFunction extends EasyStatement
{

    public function __construct(private readonly FunctionObject             $object,
                                private readonly Code                       $code,
                                private readonly DatatypeValidatorInterface $returnType)
    {
    }

    public function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        foreach ($this->code->getStatements() as $statement) {
            $result = $statement->execute($currentEnvironment, $this->upper);
            if ($result->isActionRequired()) {
                $action = $result->getAction();
                if ($action instanceof ReturnExecutionResult) {
                    return $this->return($action->getValue());
                }
                //TODO if continue or redo throw error
            }
        }

        return $this->return(Void);
    }

    private function return($value): ReturnLoad
    {
        if ($this->returnType->validate($value)) {
            return new ReturnLoad($value);
        }
        //TODO throw specialized Exception
        $this->upper->transmit(new Exception());

        return new ExceptionReturnLoad();
    }
}