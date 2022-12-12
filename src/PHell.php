<?php

namespace PHell;

use PHell\Flow\Main\Code;
use PHell\Flow\Main\Runtime;

class PHell
{
    public function execute(Code $code): void
    {
        $runtime = new Runtime($code);
        $runtime->execute($runtime, $runtime);
    }
}