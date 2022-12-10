<?php

namespace PHell\Flow\Data\Datatypes;

class PHellObjectDatatype extends AbstractType implements DatatypeInterface
{

    const TYPE_OBJECT = 'object';

    /**
     * @param string|null $name
     * if $name is null the actual names aren't checked, just if the other is an Object
     */
    public function __construct(private ?string $name)
    {
        if ($this->name !== null) {
            $this->name = 'f/' . $this->name;
        }
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        if ($this->name === null) {
            if ($datatype instanceof PHellObjectDatatype) {
                return new DatatypeValidation(true, 0);
            }
            return new DatatypeValidation(false, 0);
        }
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
        return self::TYPE_OBJECT.'<"'.$this->name.'">';
    }

}