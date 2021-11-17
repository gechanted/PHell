<?php
namespace PHell\Code\Datatypes;

use PHell\Code\Statement;

class StringType implements Statement
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

    public function getValue(): StringType
    {
        return $this;
    }

    public function getString(): string
    {
        return $this->v;
    }
}