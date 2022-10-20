<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Functions\FunctionObject;

class Exception extends FunctionObject
{

    public function __construct(string $name, string $msg, array $parentNames = [])
    {
        parent::__construct($name, null, null, null);

        $this->setNormalVar('msg', new Strin($msg));

        $parentNames[] = 'Exception';
        foreach ($parentNames as $parent) {
            $this->extendWithoutPrecaution(new FunctionObject($parent, null, null, null));
        }
    }
}