<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Data\Data\Arra;

class ArrayType extends AbstractType implements DatatypeInterface
{

    const TYPE_ARRAY = 'array';

    public function __construct(private ?DatatypeInterface $type = null)
    {
    }

    /** @return string[] */
    public function getNames(): array
    {
        return [self::TYPE_ARRAY];
    }

    public function dumpType(): string
    {
        return 'array<'.$this->type->dumpType().'>';
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        $result = false;
        $depth = 0;
        if ( in_array(self::TYPE_ARRAY, $datatype->getNames(), true) ) {
            $result = true;
            if ($this->type !== null) {  //requires check
                if ($datatype instanceof ArrayType) { //is checkable

                    if ($datatype->getType() instanceof UnknownDatatype
                        && $datatype instanceof Arra)
                    {
                        foreach ($datatype->v() as $subDT) {
                            $Vresult = $this->type->validate($subDT);
                            if ($Vresult->isSuccess() === false) {
                                return new DatatypeValidation(false, 0);
                            }
                        }
                        $datatype->setType($this->type);
                        return new DatatypeValidation(true, 0);
                    }

                    return $this->type->validate($datatype->getType());
                }
            }
        }
        return new DatatypeValidation($result, $depth);
    }

    public function getType(): ?DatatypeInterface
    {
        return $this->type;
    }

    public function setType(?DatatypeInterface $type): void
    {
        $this->type = $type;
    }
}