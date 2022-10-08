<?php
namespace PHell\Flow\Data\Data;

use PHell\Code\Statement;
use PHell\Flow\Data\Datatypes\BooleanType;

//TODO thats not right
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