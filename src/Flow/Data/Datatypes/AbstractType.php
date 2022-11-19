<?php

namespace PHell\Flow\Data\Datatypes;


abstract class AbstractType implements DatatypeInterface
{

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return $datatype->isA($this);
    }

    public function isA(DatatypeInterface $datatype): DatatypeValidation
    {
        return $datatype->realValidate($this);
    }
}