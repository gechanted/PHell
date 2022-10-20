<?php

foreach (null as $what) {

}


class XD {
    public function __toString(): string
    {
        return '';
    }
}
var_dump(is_string(new XD()));

//$name = 'strpos';
//echo call_user_func_array($name, ['haystack', 'ay']);

function XDXD(): void
{
}

$name = 'XDXD';

$function = new ReflectionFunction($name);
foreach ($function->getParameters() as $parameter) {

    echo $parameter->getType()->getName() .' $'. $parameter->getName() . ', ' . PHP_EOL;
}

var_dump(call_user_func_array($name, []));
