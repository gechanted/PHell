<?php

function XDXD(\PHell\Flow\Functions\LambdaFunction $iwas, ?bool $iwasAnderes) {

}

//$name = 'strpos';
$name = 'XDXD';
//$name = 'function_exists';
//call_user_func($name, $name);

$function = new ReflectionFunction($name);
foreach ($function->getParameters() as $parameter) {
    echo $parameter->getType()->getName() .' $'. $parameter->getName() . ', ' . PHP_EOL;
}
