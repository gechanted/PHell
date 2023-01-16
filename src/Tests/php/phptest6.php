<?php

class A // extends B
//actually funny: PHP prevents infinite extendings (extensions?) from class A to B and back, by simply not knowing one of them XD
{
    public function getThis()
    {
        return $this;
    }
}
class B extends A {}

$b = new B();
var_dump($b->getThis());