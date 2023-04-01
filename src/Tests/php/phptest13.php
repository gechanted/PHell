<?php

interface A {
    function foo(string $param, $param2);
}

interface B {
    function foo(int $param);
}

class C  implements A, B {
    function foo(string|int $param, $param2)
    {
    }
}