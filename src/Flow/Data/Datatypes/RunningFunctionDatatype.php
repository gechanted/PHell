<?php

namespace PHell\Flow\Data\Datatypes;

class RunningFunctionDatatype extends AbstractType
{
    const TYPE_RUNNINGFUNCTION = 'runningfunction';

    public function __construct(private readonly DatatypeInterface $returnType)
    {
    }

    public function getNames(): array
    {
        return [self::TYPE_RUNNINGFUNCTION];
    }

    public function dumpType(): string
    {
        return self::TYPE_RUNNINGFUNCTION.'<'.$this->returnType->dumpType().'>';
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_RUNNINGFUNCTION, $datatype->getNames(), true), 0);
    }
}