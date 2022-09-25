<?php

namespace PHell\Code\Datatypes;

class PHellObjectDatatype implements DatatypeInterface
{

    public function __construct(private readonly string $name)
    {
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return $datatype->validate($this);
    }

    public function getNames(): array
    {
        return [$this->name];
    }
}