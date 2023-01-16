<?php

class A {
    public function __toString(): string
    {
        return 'xXxSniper69';
    }

    public function returnString(): string
    {
        return new A();
    }
}
$a = new A();
var_dump(is_string($a)); //false
var_dump($a->returnString()); //automatic cast