<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Datatypes\ArrayType;
use PHell\Flow\Data\Datatypes\BooleanType;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Data\Datatypes\StringType;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesisParameter;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\Statement;

class PHPLambdaFunction extends LambdaFunction
{

    public function __construct(private readonly PHPFunctionContainer $function)
    {
        $params = [];
        foreach ($function->getParameters() as $parameter) {
            if ($parameter->getType() === null) {
                $datatype = new UnknownDatatype();
            } else if($parameter->getType()->getName() === 'string') {
                $datatype = new StringType();
            } else if($parameter->getType()->getName() === 'int') {
                $datatype = new IntegerType();
            } else if($parameter->getType()->getName() === 'float') {
                $datatype = new FloatType();
            } else if($parameter->getType()->getName() === 'array') {
                $datatype = new ArrayType();
            } else if($parameter->getType()->getName() === 'bool') {
                $datatype = new BooleanType();
            } else if($parameter->getType()->getName() === 'callable') {
                $datatype = new UnknownDatatype(); //TODO maybe with invoke ? and UnexecutedFunctionCollection ?
            } else if($parameter->getType()->getName() === 'object') {
                $datatype = new UnknownDatatype(); //TODO maybe : have to work with PHPObjectDatatype
            } else {
                $datatype = new UnknownDatatype();
            }
            $params[] = new ValidatorFunctionParenthesisParameter($parameter->getName(), $datatype);
        }
        $parenthesis = new ValidatorFunctionParenthesis($params, new UnknownDatatype());

        parent::__construct($this->function->getName(), null, $parenthesis, new Code([]));
    }

    public function generateRunningFunction(DataFunctionParenthesis $parenthesis, FunctionObject $stack): Statement
    {
        return new RunningPHPFunction($this->function, $parenthesis);
    }
}