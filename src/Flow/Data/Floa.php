<?php
namespace PHell\Flow\Data;

use PHell\Code\Statement;
use PHell\Flow\Datatypes\FloatType;

class Floa extends FloatType implements Statement
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

    public function getValue(): Floa
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