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

    public function m()
    {
        $this->message();
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

    public function m() {
        parent::m();
    }
}

class C extends B {

    public function message(): void
    {
        echo 'C';
    }
}

$c = new C(); //output b : parent this calls reference back to original object
$c->m();