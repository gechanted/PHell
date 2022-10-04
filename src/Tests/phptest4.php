<?php


//$name = 'strpos';
//echo call_user_func_array($name, ['haystack', 'ay']);

function XDXD(\PHell\Flow\Functions\LambdaFunction $iwas, ?bool $iwasAnderes) {

}

$name = 'XDXD';

$function = new ReflectionFunction($name);
foreach ($function->getParameters() as $parameter) {

    echo $parameter->getType()->getName() .' $'. $parameter->getName() . ', ' . PHP_EOL;
}
