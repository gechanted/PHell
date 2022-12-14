<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Functions\PHPObject;

/**
 * @see PHPObject
 * !!! EVERYTHING IN HERE SHOULD BE DUPLICATED AND MATCHING WITH PHPObject !!!
 */
class PHPObjectDatatype extends PHellObjectDatatype implements DatatypeInterface
{
    const PHP_OBJECT_TYPE = 'PhpObject';

    public function __construct(private readonly ?string $name)
    {
        parent::__construct($this->name);
    }

    public function dumpType(): string
    {
        return self::TYPE_OBJECT.'('.self::PHP_OBJECT_TYPE.')<"'.$this->name.'">';
    }
}