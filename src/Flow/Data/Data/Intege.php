<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Main\Statement;

class Intege extends IntegerType implements Statement
{
    private int $v;

    public function __construct(int $v)
    {
        $this->v = $v;
    }

    public static function n(int $v): self
    {
        return new self($v);
    }

    public function getValue(): Intege
    {
        return $this;
    }

    public function getInt(): int
    {
        return $this->v;
    }

    public function getFloat(): float
    {
        return $this->v + 0.0;
    }

    public function getString(): string
    {
        return $this->v . '';
    }
}