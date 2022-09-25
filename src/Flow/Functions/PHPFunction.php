<?php

namespace PHell\Flow\Functions;

use PHell\Code\Code;
use PHell\Code\Datatypes\BooleanType;
use PHell\Code\Datatypes\FloatType;
use PHell\Code\Datatypes\IntegerType;
use PHell\Code\Datatypes\StringType;
use PHell\Code\Datatypes\UnknownDatatype;
use ReflectionFunction;

class PHPFunction extends LambdaFunction
{

    public function __construct(string $name)
    {
        $function = new ReflectionFunction($name);
        $params = [];
        foreach ($function->getParameters() as $parameter) {
            if ($parameter->getType() === null) {
                $datatype = new UnknownDatatype();
            } else if($parameter->getType()->getName() === 'string') {
                $datatype = new StringType('');
            } else if($parameter->getType()->getName() === 'int') {
                $datatype = new IntegerType(0);
            } else if($parameter->getType()->getName() === 'float') {
                $datatype = new FloatType(0);
            } else if($parameter->getType()->getName() === 'bool') {
                $datatype = new BooleanType(false);
            } else {
                $datatype = new UnknownDatatype();
            }
            $params[] = new FunctionParenthesisParameter($parameter->getName(), $datatype);
        }
        $parenthesis = new FunctionParenthesis($params, new UnknownDatatype());

        parent::__construct($name, null, $parenthesis, new Code());//TODO CODE is not valid
    }
}