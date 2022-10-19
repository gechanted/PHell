<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\DatatypeValidators\ArrayTypeValidator;

class ArrayType extends ArrayTypeValidator implements DatatypeInterface
{

    public function __construct(private readonly ?DatatypeInterface $type = null)
    {
        parent::__construct($this->type);
    }

    /** @return string[] */
    public function getNames(): array
    {
        return [self::TYPE_ARRAY];
    }

    public function getType(): ?DatatypeInterface
    {
        return $this->type;
    }

}