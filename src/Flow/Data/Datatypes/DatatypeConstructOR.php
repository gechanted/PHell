<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Exceptions\ShouldntHappenException;

class DatatypeConstructOR implements DatatypeInterface
{

    /**
     * @param DatatypeInterface[] $datatypes
     */
    public function __construct(private readonly array $datatypes)
    {
    }

    public function getNames(): array
    {
        throw new ShouldntHappenException();
    }

    public function realValidate(DatatypeInterface $givenIn): DatatypeValidation
    {
        $best = null;
        foreach ($this->datatypes as $type) {
            $result = $type->validate($givenIn);
            if ($result->isSuccess()) {

                if ($best === null) {
                    $best = $result;
                } elseif ($best->getDepth() > $result->getDepth()) {
                    $best = $result;
                }

            }
        }

        if ($best === null) {
            return new DatatypeValidation(false, 0);
        }
        return $best;
    }

    public function dumpType(): string
    {
        $result = '';
        foreach ($this->datatypes as $type) {
            if ($result !== '') {
                $result .= ' || ';
            }
            $result .= $type->dumpType();
        }
        return '(' . $result . ')';
    }

    public function isA(DatatypeInterface $givenIn): DatatypeValidation
    {
        $highestDepth = null;
        foreach ($this->datatypes as $type) {
            $result = $givenIn->validate($type);
            if ($result->isSuccess() === false) {
                return new DatatypeValidation(false, 0);
            } else {

                if ($highestDepth === null) {
                    $highestDepth = $result->getDepth();
                } elseif ($highestDepth < $result->getDepth()) {
                    $highestDepth = $result->getDepth();
                }

            }
        }

        return new DatatypeValidation(true, $highestDepth);
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return $datatype->isA($this);
    }
}