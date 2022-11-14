<?php

namespace PHell\Commands\Loop;

use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\Code;
use PHell\Flow\Main\EasyCommand;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class ForLoop extends EasyCommand
{
    public function __construct(private readonly Code      $setupCode,
                                private readonly Statement $forLoopParenthesis,
                                private readonly Code      $executionCode
    ){}

    protected function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        foreach ($this->setupCode->getStatements() as $statement) {
            $result = $statement->execute($currentEnvironment, $this->upper);
            if ($result->isActionRequired()) {
                return $result;
            }
        }

        $loop = new DoWhileLoop(new Code(), $this->forLoopParenthesis, $this->executionCode);

        return $loop->execute($currentEnvironment, $this->upper);
    }

}