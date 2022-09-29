<?php

namespace PHell\Flow\Functions;

use PHell\Code\Code;
use PHell\Code\DatatypeValidators\BooleanTypeValidator;
use PHell\Code\DatatypeValidators\FloatTypeValidator;
use PHell\Code\DatatypeValidators\IntegerTypeValidator;
use PHell\Code\DatatypeValidators\StringTypeValidator;
use PHell\Code\DatatypeValidators\UnknownDatatypeValidator;
use ReflectionFunction;

class PHPFunction extends LambdaFunction
{

    public function __construct(string $name)
    {
        $function = new ReflectionFunction($name);
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
            } else if($parameter->getType()->getName() === 'bool') {
                $datatype = new BooleanTypeValidator();
            } else {
                $datatype = new UnknownDatatypeValidator();
            }
            $params[] = new FunctionParenthesisParameter($parameter->getName(), $datatype);
        }
        $parenthesis = new FunctionParenthesis($params, new UnknownDatatypeValidator());

        parent::__construct($name, null, $parenthesis, new Code());//TODO CODE is not valid
    }
}