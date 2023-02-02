<?php

class A {

    public function __construct()
    {
        $this->message();
    }

    public function message(): void
    {
        echo 'A';
    }
}

class B extends A {

    public function __construct()
    {
        parent::__construct(); //prove
    }

    public function message(): void
    {
        echo 'B';
    }
}

new B(); //output b : parent this calls reference back to original object