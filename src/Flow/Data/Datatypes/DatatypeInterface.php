<?php

namespace PHell\Flow\Data\Datatypes;

interface DatatypeInterface
{

    /** @return string[] */
    public function getNames(): array; //function/UserNamedFunction
                                        //string
                                        //bool..

    public function dumpType(): string;

    /**
     * @param DatatypeInterface $datatype
     * @return DatatypeValidation
     *
     * the validation function you should use !
     *
     * internally calls the isA() function
     */
    public function validate(DatatypeInterface $datatype): DatatypeValidation;

    /**
     * @param DatatypeInterface $datatype
     * @return DatatypeValidation
     *
     * the opposite of validate
     *
     * internally calls the realValidate() function
     */
    public function isA(DatatypeInterface $datatype): DatatypeValidation;

    /**
     * @param DatatypeInterface $datatype
     * @return DatatypeValidation
     *
     * the actual validation
     * the 2 functions from before are for the complex types to work stuff out
     */
    public function realValidate(DatatypeInterface $datatype): DatatypeValidation;
}