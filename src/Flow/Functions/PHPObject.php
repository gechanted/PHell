<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Data\Datatypes\DatatypeValidation;
use PHell\Flow\Data\Datatypes\PHPObjectDatatype;

/**
 * @see PHPObjectDatatype
 */
class PHPObject extends FunctionObject
{

    private \ReflectionObject $reflection;

    public function __construct(private readonly object $object)
    {
        $this->reflection = new \ReflectionObject($this->object);

        parent::__construct($this->reflection->getName(), null, null, null);

        foreach ($this->reflection->getMethods() as $method) {
            $phellFunction = new PHPLambdaFunction(new PHPMethod($method, $this->object));

            if ($method->isPrivate()){ $this->addPrivateFunction($phellFunction); }
            if ($method->isProtected()){ $this->addProtectedFunction($phellFunction); }
            if ($method->isPublic()){ $this->addPublicFunction($phellFunction); }
        }

        foreach ($this->reflection->getProperties() as $property) {

            $visibility = self::VISIBILITY_PRIVATE;
            if ($property->isPublic()) { $visibility = self::VISIBILITY_PUBLIC; }
            if ($property->isProtected()) { $visibility = self::VISIBILITY_PROTECTED; }

            $this->setNormalVar($property->getName(), RunningPHPFunction::convertPHPValue($property->getValue()), $visibility);
        }
    }

    public function phpV()
    {
        return $this->object;
    }

    public function getObject(): object
    {
        return $this->object;
    }

    public function dumpType(): string
    {
        return self::TYPE_OBJECT.'('.PHPObjectDatatype::PHP_OBJECT_TYPE.')<"'.$this->reflection->getName().'">';
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        $validation = parent::realValidate($datatype);
        if ($validation->isSuccess() && $datatype instanceof PHPObject && $datatype->getObject() instanceof $this->object) {
            return $validation;
        }
        return new DatatypeValidation(false, 0);
    }
}