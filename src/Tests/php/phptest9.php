<?php

class A {
    private A $var;

    public function __construct()
    {
        var_dump(isset($this->var)); //works
        var_dump($this->var); //throws fatal
        if ($this->var === null) {
            echo 'TRUE';
        } else {
            echo 'FALSE';
        }

    }
}

new A();