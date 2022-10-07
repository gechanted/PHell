<?php
namespace PHell\Flow\Data\Data;

use PHell\Code\Statement;
use PHell\Flow\Data\Datatypes\StringType;

class Strin extends StringType implements Statement
{
    private string $v;

    public function __construct(string $v)
    {
        $this->v = $v;
    }

    public static function n(string $v): self
    {
        return new self($v);
    }

    public function getValue(): Strin
    {
        return $this;
    }

    public function getString(): string
    {
        return $this->v;
    }
}