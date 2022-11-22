<?php

class A {
    public function getThis()
    {
        return $this;
    }
}
class B extends A {}

$b = new B();
var_dump($b->getThis());