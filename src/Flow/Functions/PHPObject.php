<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Data\Datatypes\PHPObjectDatatype;

/**
 * @see PHPObjectDatatype
 * !!! EVERYTHING IN HERE SHOULD BE DUPLICATED AND MATCHING WITH PHPObjectDatatype !!!
 */
class PHPObject extends FunctionObject
{

    public function __construct(object $object)
    {
        $reflection = new \ReflectionObject($object);

        parent::__construct($reflection->getName(), null, null, null);

        foreach ($reflection->getMethods() as $method) {
            $phellFunction = new PHPLambdaFunction(new PHPMethod($method, $object));

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

//    /** @return string[] */
//    public function getNames(): array
//    {
//
//    }
}