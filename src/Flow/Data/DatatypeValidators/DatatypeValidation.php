<?php

namespace PHell\Flow\Data\DatatypeValidators;

class DatatypeValidation
{

    public function __construct(private readonly bool $success, private readonly int $depth)
    {
    }

    public function getDepth(): int
    {
        return $this->depth;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }
}