<?php
namespace PHell\Flow\Data;

use PHell\Code\Statement;
use PHell\Flow\Datatypes\BooleanType;

class Boolea extends BooleanType implements Statement
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

    public function getValue(): Boolea
    {
        return $this;
    }

    public function getBool(): bool
    {
        return $this->v;
    }
}