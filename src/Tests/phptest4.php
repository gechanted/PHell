<?php


class XD {

    private $str = 'b,bmm';

    public function __toString(): string
    {
        return $this->str;
    }

    public function XDXD(int $str)
    {
        return 6;
    }
}
//var_dump(is_string(new XD()));

//$name = 'strpos';
//echo call_user_func_array($name, ['haystack', 'ay']);

function XDXD()
{
    return 5;
}

//$name = 'XDXD';
//$function = new ReflectionFunction($name);
$xd = new XD();
$object = new ReflectionObject($xd);
foreach ($object->getMethods() as $function) {
    echo 'f(x) = ' . $function->getName() .'('. PHP_EOL;
    foreach ($function->getParameters() as $parameter) {

        echo '  '.$parameter->getType()->getName() . ' $' . $parameter->getName() . ', ' . PHP_EOL;
    }
    echo ')'. PHP_EOL;
    echo '=> ' . $function->invoke($xd, 3) .PHP_EOL;
}
var_dump( $object->getProperties());


//var_dump(call_user_func_array($name, []));
