<?php

namespace PHell\Flow\Data\Datatypes;

class PHellObjectDatatype extends AbstractType implements DatatypeInterface
{

    public function __construct(private readonly string $name)
    {
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        $counter = 0;
        foreach ($datatype->getNames() as $name) {
            if ($name === $this->name) {
                return new DatatypeValidation(true, $counter);
            }
            $counter++;
        }
        return new DatatypeValidation(false, 0);
    }

    public function getNames(): array
    {
        return [$this->name];
    }

    public function dumpType(): string
    {
        return 'obj';
    }

}