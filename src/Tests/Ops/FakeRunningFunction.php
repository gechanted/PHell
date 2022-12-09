<?php

namespace PHell\Tests\Ops;

use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Code;

class FakeRunningFunction extends RunningFunction
{
    public function __construct()
    {
        parent::__construct(new FunctionObject('', null, null, null), new Code(), new UnknownDatatype());
    }
}