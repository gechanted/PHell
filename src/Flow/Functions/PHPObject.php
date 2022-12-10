<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Datatypes\PHPObjectDatatype;

/**
 * @see PHPObjectDatatype
 * !!! TODO EVERYTHING IN HERE SHOULD BE DUPLICATED AND MATCHING WITH PHPObjectDatatype !!!
 */
class PHPObject extends FunctionObject
{

    public function __construct(private readonly object $object)
    {
        $reflection = new \ReflectionObject($this->object);

        parent::__construct($reflection->getName(), null, null, null);

        foreach ($reflection->getMethods() as $method) {
            $phellFunction = new PHPLambdaFunction(new PHPMethod($method, $this->object));

            if ($method->isPrivate()){ $this->addPrivateFunction($phellFunction); }
            if ($method->isProtected()){ $this->addProtectedFunction($phellFunction); }
            if ($method->isPublic()){ $this->addPublicFunction($phellFunction); }
        }

        foreach ($reflection->getProperties() as $property) {

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

//    /** @return string[] */
//    public function getNames(): array
//    {
//
//    }
}