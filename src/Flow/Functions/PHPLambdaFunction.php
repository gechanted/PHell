<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\DatatypeValidators\ArrayTypeValidator;
use PHell\Flow\Data\DatatypeValidators\BooleanTypeValidator;
use PHell\Flow\Data\DatatypeValidators\FloatTypeValidator;
use PHell\Flow\Data\DatatypeValidators\IntegerTypeValidator;
use PHell\Flow\Data\DatatypeValidators\StringTypeValidator;
use PHell\Flow\Data\DatatypeValidators\UnknownDatatypeValidator;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesisParameter;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\Statement;

class PHPLambdaFunction extends LambdaFunction
{

    public function __construct(private readonly PHPFunctionContainer $function)
    {
        $params = [];
        foreach ($function->getParameters() as $parameter) {
            if ($parameter->getType() === null) {
                $datatype = new UnknownDatatypeValidator();
            } else if($parameter->getType()->getName() === 'string') {
                $datatype = new StringTypeValidator();
            } else if($parameter->getType()->getName() === 'int') {
                $datatype = new IntegerTypeValidator();
            } else if($parameter->getType()->getName() === 'float') {
                $datatype = new FloatTypeValidator();
            } else if($parameter->getType()->getName() === 'array') {
                $datatype = new ArrayTypeValidator();
            } else if($parameter->getType()->getName() === 'bool') {
                $datatype = new BooleanTypeValidator();
            } else if($parameter->getType()->getName() === 'object') {
                $datatype = new UnknownDatatypeValidator(); //TODO maybe
            } else {
                $datatype = new UnknownDatatypeValidator();
            }
            $params[] = new ValidatorFunctionParenthesisParameter($parameter->getName(), $datatype);
        }
        $parenthesis = new ValidatorFunctionParenthesis($params, new UnknownDatatypeValidator());

        parent::__construct($this->function->getName(), null, $parenthesis, new Code([]));
    }

    public function generateRunningFunction(FunctionParenthesis $parenthesis, FunctionObject $stack): Statement
    {
        return new RunningPHPFunction($this->function, $parenthesis);
    }
}