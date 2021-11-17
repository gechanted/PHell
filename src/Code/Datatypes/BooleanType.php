<?php
namespace PHell\Code\Datatypes;

use PHell\Code\Statement;

class BooleanType implements Statement
{
    private bool $v;

    public function __construct(bool $v)
    {
        $this->v = $v;
    }

    public static function n(bool $v): self
    {
        return new self($v);
    }

    public function getValue(): BooleanType
    {
        return $this;
    }

    public function getBool(): bool
    {
        return $this->v;
    }
}