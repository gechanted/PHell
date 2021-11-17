<?php
namespace PHell\Code\Datatypes;

use PHell\Code\Statement;

class FloatType implements FloatInterface, Statement
{
    private float $v;

    public function __construct(float $v)
    {
        $this->v = $v;
    }

    public static function n(float $v): self
    {
        return new self($v);
    }

    public function getValue(): FloatType
    {
        return $this;
    }

    public function getFloat(): float
    {
        return $this->v;
    }

    public function getString(): string
    {
        return $this->v . '';
    }
}