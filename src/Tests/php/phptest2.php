<?php

class Implementor {
    protected string $prot = 'hi';
    public function __construct(string $string)
    {
    }
}

class SecondImplementor extends Implementor {
    protected string $prot = 'bb';

}

class Inheritor extends Implementor {
    public function __construct()
    {
        parent::__construct('to up');
        //not able to construct "SecondImplementor"
    }
}
