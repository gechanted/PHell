<?php

namespace PHell\Flow\Functions;

class Runtime
{
    private static Runtime $self;

    public static function get(): self
    {
        if (self::$self === null) {
            self::$self = new self();
        }
        return self::$self;
    }


    private FunctionObject $current;

    public function current(): FunctionObject
    {
        if ($this->current === null) {
            $this->current = new FunctionObject();
        }
        return $this->current;
    }

}